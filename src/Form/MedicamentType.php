<?php

namespace App\Form;

use App\Entity\GroupsMedic;
use App\Entity\Medicament;
use App\Entity\Symptome;
use App\Repository\CatMedicamentsRepository;
use App\Repository\GroupsMedicRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class MedicamentType extends AbstractType
{
    private $gm;
    private $cm;

    public function __construct(GroupsMedicRepository $gm, CatMedicamentsRepository $cm)
    {
        $this->gm = $gm;
        $this->cm = $cm;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            //->add('notice', FileType::class)


            //->add('picture', FileType::class)
               ->add ('id_group', ChoiceType::class, [
                    'choices' => $this->gm->getChoices()
            ])
        ->add('id_cat', ChoiceType::class, [
            'choices' => $this->cm->getChoices()
        ])
          /* ->add('id_group', EntityType::class, [
                'class' => GroupsMedic::class,
                'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('g')
                    ->orderBy('g.Name', 'ASC');
                   // ->getQuery()
                       // ->getResult();
                },
          'choice_label' => 'name',
            ])*/
            ->add('enable')
            ->add('commentaires')
            ->add('symptomes', EntityType::class, [
                'class' => Symptome::class,
                'choice_label' => 'name',
                'multiple' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Medicament::class,
            'translation_domain' => 'forms'
        ]);
    }

    public function getTypes()
    {
        $types = Medicament::TYPES;
       sort ($types);

       /* $output = [];
        foreach ($types  as $key => $value)
        {
            $output[$value] = $key;
        }*/
        return array_flip($types);
    }
}
