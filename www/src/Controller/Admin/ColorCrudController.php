<?php

namespace App\Controller\Admin;

use App\Entity\Color;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ColorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Color::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Color')
            ->setEntityLabelInPlural('Color')
            ->setSearchFields(['id', 'name', 'color']);
    }

    public function configureFields(string $pageName): iterable
    {
        $name = TextField::new('name');
        $color = TextField::new('color')->setTemplatePath('wandi_color_picker.html.twig');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$name, $color];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$name, $color];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$name, $color];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name, $color];
        }
    }
}
