<?php

namespace App\Controller\Admin;

use App\Entity\Campaign;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CampaignCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Campaign::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Campaign')
            ->setEntityLabelInPlural('Campaign')
            ->setSearchFields(['id', 'name', 'slug', 'campaignSubject', 'campaignTitle', 'campaignDescription', 'ogCampaignDescription', 'ogImageDe', 'ogImageFr', 'hero', 'total', 'campaignInfoLead', 'campaignInfo', 'howItWorksStep1', 'howItWorksStep2', 'howItWorksStep3', 'howItWorksFinish', 'donorBox', 'shareTextBox', 'faqTitle', 'faqText', 'heroBackground', 'mailThanksText', 'heroSubline']);
    }

    public function configureFields(string $pageName): iterable
    {
        $name = TextField::new('name');
        $slug = TextField::new('slug');
        $start = DateTimeField::new('start');
        $end = DateTimeField::new('end');
        $arguments = AssociationField::new('arguments');
        $regions = AssociationField::new('regions');
        $wipCounts = AssociationField::new('wipCounts');
        $pages = AssociationField::new('pages');
        $politicianType = AssociationField::new('politicianType');
        $commissions = AssociationField::new('commissions');
        $campaignSubject = TextField::new('campaignSubject');
        $campaignTitle = TextField::new('campaignTitle');
        $campaignDescription = TextareaField::new('campaignDescription');
        $ogCampaignDescription = TextareaField::new('ogCampaignDescription');
        $ogImageFileDe = Field::new('ogImageFileDe');
        $ogImageFileFr = Field::new('ogImageFileFr');
        $heroBackgroundFile = Field::new('heroBackgroundFile');
        $colors = AssociationField::new('colors');
        $hero = TextField::new('hero');
        $heroSubline = TextField::new('heroSubline');
        $total = TextField::new('total');
        $campaignInfoLead = TextareaField::new('campaignInfoLead');
        $campaignInfo = TextareaField::new('campaignInfo');
        $howItWorksStep1 = TextField::new('howItWorksStep1');
        $howItWorksStep2 = TextField::new('howItWorksStep2');
        $howItWorksStep3 = TextField::new('howItWorksStep3');
        $howItWorksFinish = TextField::new('howItWorksFinish');
        $donorBox = TextareaField::new('donorBox');
        $shareTextBox = TextareaField::new('shareTextBox');
        $faqTitle = TextField::new('faqTitle');
        $faqText = TextareaField::new('faqText');
        $mailThanksText = TextareaField::new('mailThanksText');
        $doubleOptIn = Field::new('doubleOptIn');
        $projectUpdatesDefault = Field::new('projectUpdatesDefault');
        $platformUpdatesDefault = Field::new('platformUpdatesDefault');
        $ogImageDe = ImageField::new('ogImageDe');
        $ogImageFr = ImageField::new('ogImageFr');
        $heroBackground = ImageField::new('heroBackground');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$name, $slug, $start, $end, $campaignTitle, $doubleOptIn];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$ogImageDe, $ogImageFr, $heroBackground];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$name, $slug, $start, $end, $arguments, $regions, $wipCounts, $pages, $politicianType, $commissions, $campaignSubject, $campaignTitle, $campaignDescription, $ogCampaignDescription, $ogImageFileDe, $ogImageFileFr, $heroBackgroundFile, $colors, $hero, $heroSubline, $total, $campaignInfoLead, $campaignInfo, $howItWorksStep1, $howItWorksStep2, $howItWorksStep3, $howItWorksFinish, $donorBox, $shareTextBox, $faqTitle, $faqText, $mailThanksText, $doubleOptIn, $projectUpdatesDefault, $platformUpdatesDefault];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name, $slug, $start, $end, $arguments, $regions, $wipCounts, $pages, $politicianType, $commissions, $campaignSubject, $campaignTitle, $campaignDescription, $ogCampaignDescription, $ogImageFileDe, $ogImageFileFr, $heroBackgroundFile, $colors, $hero, $heroSubline, $total, $campaignInfoLead, $campaignInfo, $howItWorksStep1, $howItWorksStep2, $howItWorksStep3, $howItWorksFinish, $donorBox, $shareTextBox, $faqTitle, $faqText, $mailThanksText, $doubleOptIn, $projectUpdatesDefault, $platformUpdatesDefault];
        }
    }
}
