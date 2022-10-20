<?php

namespace App\Controller\Admin;

use App\Entity\Commission;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CommissionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commission::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Commission')
            ->setEntityLabelInPlural('Commission')
            ->setSearchFields(['id', 'name', 'abbreviation']);
    }

    public function configureFields(string $pageName): iterable
    {
        $name = TextField::new('name');
        $abbreviation = TextField::new('abbreviation');
        $createdAt = DateTimeField::new('createdAt');
        $updatedAt = DateTimeField::new('updatedAt');
        $politicianType = AssociationField::new('politicianType');
        $members = AssociationField::new('members');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $name, $abbreviation, $createdAt, $politicianType, $members];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $name, $abbreviation, $createdAt, $updatedAt, $politicianType, $members];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$name, $abbreviation, $createdAt, $updatedAt, $politicianType, $members];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name, $abbreviation, $createdAt, $updatedAt, $politicianType, $members];
        }
    }
}
