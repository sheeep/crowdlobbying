<?php

namespace App\Controller\Admin;

use App\Entity\Argument;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class ArgumentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Argument::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Argument')
            ->setEntityLabelInPlural('Argument')
            ->setSearchFields(['id', 'argument']);
    }

    public function configureFields(string $pageName): iterable
    {
        $argument = TextareaField::new('argument');
        $createdAt = DateTimeField::new('createdAt');
        $updatedAt = DateTimeField::new('updatedAt');
        $campaign = AssociationField::new('campaign');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $createdAt, $campaign];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $argument, $createdAt, $updatedAt, $campaign];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$argument, $createdAt, $updatedAt, $campaign];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$argument, $createdAt, $updatedAt, $campaign];
        }
    }
}
