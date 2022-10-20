<?php

namespace App\Controller\Admin;

use App\Entity\CampaignEntry;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CampaignEntryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CampaignEntry::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('CampaignEntry')
            ->setEntityLabelInPlural('CampaignEntry')
            ->setSearchFields(['id', 'color']);
    }

    public function configureFields(string $pageName): iterable
    {
        $optInInformation = Field::new('optInInformation');
        $optInInformationPartner = Field::new('optInInformationPartner');
        $color = TextField::new('color');
        $confirmed = Field::new('confirmed');
        $createdAt = DateTimeField::new('createdAt');
        $updatedAt = DateTimeField::new('updatedAt');
        $person = AssociationField::new('person');
        $campaign = AssociationField::new('campaign');
        $politician = AssociationField::new('politician');
        $argument = AssociationField::new('argument');
        $personArgument = AssociationField::new('personArgument');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $optInInformation, $optInInformationPartner, $color, $confirmed, $createdAt, $person];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $optInInformation, $optInInformationPartner, $color, $confirmed, $createdAt, $updatedAt, $person, $campaign, $politician, $argument, $personArgument];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$optInInformation, $optInInformationPartner, $color, $confirmed, $createdAt, $updatedAt, $person, $campaign, $politician, $argument, $personArgument];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$optInInformation, $optInInformationPartner, $color, $confirmed, $createdAt, $updatedAt, $person, $campaign, $politician, $argument, $personArgument];
        }
    }
}
