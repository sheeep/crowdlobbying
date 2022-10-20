<?php

namespace App\Controller\Admin;

use App\Entity\PoliticianType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PoliticianTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PoliticianType::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('PoliticianType')
            ->setEntityLabelInPlural('PoliticianType')
            ->setSearchFields(['id', 'name']);
    }

    public function configureFields(string $pageName): iterable
    {
        $name = TextField::new('name');
        $createdAt = DateTimeField::new('createdAt');
        $updatedAt = DateTimeField::new('updatedAt');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $createdAt];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $name, $createdAt, $updatedAt];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$name, $createdAt, $updatedAt];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name, $createdAt, $updatedAt];
        }
    }
}
