<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Defines the form used to search inventory.
 *
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 */
class InventoryType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // For the full reference of options defined by each form field type
        // see http://symfony.com/doc/current/reference/forms/types.html

        // By default, form fields include the 'required' attribute, which enables
        // the client-side form validation. This means that you can't test the
        // server-side validation errors from the browser. To temporarily disable
        // this validation, set the 'required' attribute to 'false':
        //
        //     $builder->add('title', null, array('required' => false, ...));

        $builder
            ->add('nama', 'text', ['label' => "Nama", 'attr' => ['placeholder' => "Fill name", 'class' => "form-control"], 'required' => true])
            ->add('quantityPerUnit', 'text', ['label' => "Kuantitas Per Unit", 'attr' => ['placeholder' => "Fill quantity per unit", 'class' => "form-control"], 'required' => true])
            ->add('unitPrice', 'text', ['label' => "Harga Per Unit", 'attr' => ['placeholder' => "Fill unit price", 'class' => "form-control"], 'required' => true])
            ->add('unitsInStock', 'text', ['label' => "Stok Unit", 'attr' => ['placeholder' => "Fill unit stock", 'class' => "form-control"], 'required' => true])
            ->add('unitsOnOrder', 'text', ['label' => "Reorder Unit", 'attr' => ['placeholder' => "Fill reorder unit", 'class' => "form-control"], 'required' => true])
            ->add('safetyStock', 'text', ['label' => "Safety Stok", 'attr' => ['placeholder' => "Fill safety stock", 'class' => "form-control"], 'required' => true])
            ->add('description', 'textarea', ['label' => "Deskripsi", 'attr' => ['placeholder' => "Fill Description", 'class' => "form-control"], 'required' => false])
            ->add('file', 'file', ['label' => "Gambar", 'attr' => ['class' => "form-control"], 'required' => false])
        ;
    }


    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'app_inventory';
    }
}
