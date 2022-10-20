<?php

namespace App\Controller\Admin;

use App\Entity\Region;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class RegionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Region::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Region')
            ->setEntityLabelInPlural('Region')
            ->setSearchFields(['id', 'name', 'slug', 'short']);
    }

    public function configureFields(string $pageName): iterable
    {
        $name = TextField::new('name');
        $slug = TextField::new('slug');
        $short = TextField::new('short');
        $createdAt = DateTimeField::new('createdAt');
        $updatedAt = DateTimeField::new('updatedAt');
        $politicians = AssociationField::new('politicians');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $short, $createdAt, $politicians];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $name, $slug, $short, $createdAt, $updatedAt, $politicians];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$name, $slug, $short, $createdAt, $updatedAt, $politicians];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name, $slug, $short, $createdAt, $updatedAt, $politicians];
        }
    }
}
