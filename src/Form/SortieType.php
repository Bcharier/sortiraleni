<?php

namespace App\Form;

use App\Entity\Etat;
use App\Entity\Participant;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\Lieu;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('dateHeureDebut')
            ->add('duree', NumberType::class, [ 'html5' => true, 'attr' => ['size' => 10, 'data-append-text' => 'minutes']])
            ->add('dateLimiteInscription')
            ->add('nbInscriptionsMax')
            ->add('infosSortie', TextareaType::class)
            /*
            ->add('etat', EntityType::class, [
                'class' => Etat::class,
                'choice_label' => 'libelle',
                'mapped' => false,
                ])
            ->add('organisateur', EntityType::class, [
                'class' => Participant::class,
                'choice_label' => 'pseudo',
            ])
            ->add('site', EntityType::class, [
                'class' => Site::class,
                'choice_label' => 'nom',
            ])
            ->add('lieu', ChoiceType::class, [
                'choices' => [],
                'choice_label' => 'nom',
                'required' => true,
                'mapped' => false,
                'by_reference' => false,
            ])
            */
            ->add('lieu', EntityType::class, [
                'class' => Lieu::class,
                'choice_label' => 'nom',
            ])
            ->add('submit', SubmitType::class, array('label' => 'Enregistrer la sortie', 'row_attr' => ['class' => 'row enregistrer'], 'attr' => ['class' => 'button enregistrer',]))
            ->add('publish', SubmitType::class, array('label'  => 'Publier la sortie', 'row_attr' => ['class' => 'row publier'], 'attr' => ['class' => 'button publier',]))
            ->add('cancel', ResetType::class, array('label'  => 'Annuler', 'row_attr' => ['class' => 'row annuler'], 'attr' => ['class' => 'button annuler',]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
