namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('firstName', TextType::class, [
            'label' => 'First Name',
        ])
        ->add('lastName', TextType::class, [
            'label' => 'Last Name',
        ])
        ->add('birthDate', DateType::class, [
            'label' => 'Date of Birth',
            'widget' => 'single_text',
        ])
        ->add('gender', ChoiceType::class, [
            'label' => 'Gender',
            'choices' => [
            'Male' => 'male',
            'Female' => 'female',
        ],
        ])
        ->add('nationality', TextType::class, [
            'label' => 'Nationality',
        ])
        ->add('email', EmailType::class, [
            'label' => 'Email Address',
        ])
        ->add('phone', TextType::class, [
            'label' => 'Phone Number',
        ])
        ->add('address', TextareaType::class, [
            'label' => 'Address',
            'attr' => ['rows' => 4],
        ])
        ->add('education', TextType::class, [
            'label' => 'Previous Education',
        ])
        ->add('program', ChoiceType::class, [
            'label' => 'Intended Program of Study',
            'choices' => [
            'MPI' => 'mpi',
            'CBA' => 'cba',
        ],
        ])
        ->add('achievements', TextareaType::class, [
            'label' => 'Achievements and Awards',
            'attr' => ['rows' => 4],
        ])
        ->add('essay', TextareaType::class, [
            'label' => 'Personal Statement',
            'attr' => ['rows' => 6],
        ])
        ->add('declaration', CheckboxType::class, [
            'label' => 'I hereby declare that the information provided is accurate and complete to the best of my knowledge.',
            'mapped' => false, // This field is not mapped to any property
        ]);
    }
}
