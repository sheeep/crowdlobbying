<?php

namespace App\Controller\Admin;

use App\Entity\PersonArgument;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PersonArgumentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PersonArgument::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('PersonArgument')
            ->setEntityLabelInPlural('PersonArgument')
            ->setSearchFields(['id', 'argument', 'locale']);
    }

    public function configureFields(string $pageName): iterable
    {
        $argument = TextareaField::new('argument');
        $locale = TextField::new('locale');
        $createdAt = DateTimeField::new('createdAt');
        $updatedAt = DateTimeField::new('updatedAt');
        $campaign = AssociationField::new('campaign');
        $campaignEntry = AssociationField::new('campaignEntry');
        $person = AssociationField::new('person');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $createdAt, $campaign, $person, $argument];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $argument, $locale, $createdAt, $updatedAt, $campaign, $campaignEntry, $person];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$argument, $locale, $createdAt, $updatedAt, $campaign, $campaignEntry, $person];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$argument, $locale, $createdAt, $updatedAt, $campaign, $person];
        }
    }
}
