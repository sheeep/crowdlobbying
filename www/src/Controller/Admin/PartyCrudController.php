<?php

namespace App\Controller\Admin;

use App\Entity\Party;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PartyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Party::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Party')
            ->setEntityLabelInPlural('Party')
            ->setSearchFields(['id', 'name', 'short']);
    }

    public function configureFields(string $pageName): iterable
    {
        $name = TextField::new('name');
        $short = TextField::new('short');
        $createdAt = DateTimeField::new('createdAt');
        $updatedAt = DateTimeField::new('updatedAt');
        $politicians = AssociationField::new('politicians');
        $logo = AssociationField::new('logo');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $short, $createdAt, $politicians, $logo];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $name, $short, $createdAt, $updatedAt, $politicians, $logo];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$name, $short, $createdAt, $updatedAt, $politicians, $logo];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name, $short, $createdAt, $updatedAt, $politicians, $logo];
        }
    }
}
