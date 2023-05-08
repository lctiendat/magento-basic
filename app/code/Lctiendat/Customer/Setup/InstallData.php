<?php

namespace Lctiendat\Brand\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Eav\Model\Config;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use \Magento\Customer\Model\Customer;


class InstallData implements InstallDataInterface
{
    private $eavConfig;

    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * @var AttributeSetFactory
     */
    private $attributeSetFactory;

    public function __construct(
        Config $eavConfig,
        EavSetupFactory $eavSetupFactory,
        AttributeSetFactory $attributeSetFactory
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig = $eavConfig;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $customerEntity = $this->eavConfig->getEntityType('customer');
        $attributeSetId = $customerEntity->getDefaultAttributeSetId();

        $attributeSet = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

        $eavSetup->addAttribute(
            \Magento\Customer\Model\Customer::ENTITY,
            'customer_mobile',
            [
                'type' => 'varchar',
                'label' => 'Customer Mobile',
                'input' => 'text',
                'sort_order' => 100,
                'position' => 100,
                'required' => false,
                'visible' => true,
                'system' => false
            ]
        )->addAttribute(
            Customer::ENTITY,
            'company',
            [
                'type' => 'varchar',
                'label' => 'Company',
                'input' => 'text',
                'sort_order' => 101,
                'position' => 101,
                'required' => false,
                'visible' => true,
                'system' => false
            ]
        );

        $customAttribute = $this->eavConfig->getAttribute(Customer::ENTITY, 'customer_mobile');

        $companyAtt =  $this->eavConfig->getAttribute(Customer::ENTITY, 'company');

        $customAttribute->addData([
            'attribute_set_id' => $attributeSetId,
            'attribute_group_id' => $attributeGroupId,
            'used_in_forms' => ['adminhtml_customer_edit']
        ]);

        $companyAtt->addData([
            'attribute_set_id' => $attributeSetId,
            'attribute_group_id' => $attributeGroupId,
            'used_in_forms' => ['adminhtml_customer', 'customer_account_create']
        ]);

        $customAttribute->save();

        $companyAtt->save();
    }
}
