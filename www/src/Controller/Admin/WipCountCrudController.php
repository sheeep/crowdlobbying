<?php

namespace App\Controller\Admin;

use App\Entity\WipCount;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class WipCountCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return WipCount::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('WipCount')
            ->setEntityLabelInPlural('WipCount')
            ->setSearchFields(['id', 'status', 'voted']);
    }

    public function configureFields(string $pageName): iterable
    {
        $status = IntegerField::new('status');
        $voted = IntegerField::new('voted');
        $createdAt = DateTimeField::new('createdAt');
        $updatedAt = DateTimeField::new('updatedAt');
        $campaign = AssociationField::new('campaign');
        $politician = AssociationField::new('politician');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $status, $voted, $createdAt, $campaign, $politician];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $status, $voted, $createdAt, $updatedAt, $campaign, $politician];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$status, $voted, $createdAt, $updatedAt, $campaign, $politician];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$status, $voted, $createdAt, $updatedAt, $campaign, $politician];
        }
    }
}
