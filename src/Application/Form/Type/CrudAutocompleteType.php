<?php

declare(strict_types=1);

namespace App\Application\Form\Type;

use Doctrine\DBAL\Types\Type;
use Ramsey\Uuid\Doctrine\UuidType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Uid\Uuid;
use Twig\Environment;

class CrudAutocompleteType extends AbstractType implements DataMapperInterface
{
    public function __construct(
        private readonly Environment $twig,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->addEventSubscriber(new FixedCrudAutocompleteSubscriber($this->twig))
            ->setDataMapper($this);
    }

    public function finishView(FormView $view, FormInterface $form, array $options): void
    {
        array_splice($view['autocomplete']->vars['block_prefixes'], -1, 0, 'ea_autocomplete_inner');

        if (($view->vars['attr']['data-allow-clear'] ?? false) && (!isset($view->vars['attr']['data-placeholder']))) {
            $view->vars['attr']['data-placeholder'] = '';
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'multiple' => false,
            'error_bubbling' => false,
            'autocomplete_callback' => null,
            'autocomplete_template' => null,
        ]);

        $resolver->setRequired(['class']);
        $resolver->setAllowedTypes('autocomplete_callback', ['null', 'callable']);
        $resolver->setAllowedTypes('autocomplete_template', ['null', 'string']);
    }

    public function getBlockPrefix(): string
    {
        return 'ea_autocomplete';
    }

    public function mapDataToForms($data, $forms): void
    {
        $form = current(iterator_to_array($forms, false));
        if (false !== $form) {
            $form->setData($data);
        }
    }

    public function mapFormsToData($forms, &$data): void
    {
        $form = current(iterator_to_array($forms, false));
        if (false !== $form) {
            $data = $form->getData();
        }
    }
}

/**
 * @internal
 */
class FixedCrudAutocompleteSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly Environment $twig,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT => 'preSubmit',
        ];
    }

    public function preSetData(FormEvent $event): void
    {
        $form = $event->getForm();
        $data = $event->getData() ?? [];

        $options = $form->getConfig()->getOptions();
        $options['compound'] = false;
        $options['choices'] = is_iterable($data) ? $data : [$data];

        $callback = $options['autocomplete_callback'] ?? null;
        $template = $options['autocomplete_template'] ?? null;

        if (null !== $template) {
            $twig = $this->twig;
            $options['choice_label'] = static function ($entity) use ($twig, $template): string {
                return $twig->render($template, ['entity' => $entity]);
            };
        } elseif (null !== $callback) {
            $options['choice_label'] = static function ($entity) use ($callback): string {
                return (string) $callback($entity);
            };
        }

        unset($options['autocomplete_callback'], $options['autocomplete_template']);

        $form->add('autocomplete', \Symfony\Bridge\Doctrine\Form\Type\EntityType::class, $options);
    }

    public function preSubmit(FormEvent $event): void
    {
        $data = $event->getData();
        $form = $event->getForm();
        $options = $form->get('autocomplete')->getConfig()->getOptions();

        if (!isset($data['autocomplete']) || '' === $data['autocomplete']) {
            $options['choices'] = [];
        } else {
            if (false === $options['id_reader']->isIntId()) {
                if (!\is_array($data['autocomplete'])) {
                    $data['autocomplete'] = [$data['autocomplete']];
                }

                $idFieldMapping = $options['em']->getClassMetadata($options['class'])->getFieldMapping($options['id_reader']->getIdField());
                if (\is_array($idFieldMapping)) {
                    $idFieldMapping = (object) $idFieldMapping;
                }
                $idFieldType = property_exists($idFieldMapping, 'type') ? $idFieldMapping->type : $idFieldMapping['type'];

                $data['autocomplete'] = array_map(
                    static function ($v) use ($options, $idFieldType) {
                        if ('ulid' === $idFieldType && class_exists(\Symfony\Component\Uid\Ulid::class) && \Symfony\Component\Uid\Ulid::isValid($v)) {
                            return \Symfony\Component\Uid\Ulid::fromBase32($v)->toRfc4122();
                        }

                        if ('uuid' === $idFieldType && class_exists(Uuid::class) && Uuid::isValid($v)) {
                            // When Ramsey UUID type is registered, UUIDs are stored as CHAR(36) strings — don't convert to binary
                            if (Type::hasType('uuid') && Type::getType('uuid') instanceof UuidType) {
                                return $v;
                            }

                            $platform = $options['em']->getConnection()->getDatabasePlatform();
                            $hasNativeGuidType = $platform->getGuidTypeDeclarationSQL([]) !== $platform->getStringTypeDeclarationSQL(['fixed' => true, 'length' => 36]);

                            return $hasNativeGuidType
                                ? Uuid::fromString($v)->toRfc4122()
                                : Uuid::fromString($v)->toBinary();
                        }

                        return $v;
                    },
                    $data['autocomplete']
                );
            }

            $options['choices'] = $options['em']->getRepository($options['class'])->findBy([
                $options['id_reader']->getIdField() => $data['autocomplete'],
            ]);
        }

        unset($options['em'], $options['loader'], $options['empty_data'], $options['choice_list'], $options['choices_as_values']);

        $form->add('autocomplete', \Symfony\Bridge\Doctrine\Form\Type\EntityType::class, $options);
    }
}
