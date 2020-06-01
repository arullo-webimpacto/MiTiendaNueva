<?php
Class AdminImportController extends AdminImportControllerCore{
    

    public function __construct()
    {
        exit("Dentro del constructor nuevo de AdminImportController");
        $this->bootstrap = true;

        parent::__construct();

        $this->entities = array(
            $this->trans('Categories', array(), 'Admin.Global'),
            $this->trans('Products', array(), 'Admin.Global'),
            $this->trans('Combinations', array(), 'Admin.Global'),
            $this->trans('Customers', array(), 'Admin.Global'),
            $this->trans('Addresses', array(), 'Admin.Global'),
            $this->trans('Brands', array(), 'Admin.Global'),
            $this->trans('Suppliers', array(), 'Admin.Global'),
            $this->trans('Alias', array(), 'Admin.Shopparameters.Feature'),
            $this->trans('Store contacts', array(), 'Admin.Advparameters.Feature'),
        );

        // @since 1.5.0
        if (Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT')) {
            $this->entities = array_merge(
                $this->entities,
                array(
                    $this->trans('Supply Orders', array(), 'Admin.Advparameters.Feature'),
                    $this->trans('Supply Order Details', array(), 'Admin.Advparameters.Feature'),
                )
            );
        }

        $this->entities = array_flip($this->entities);

        switch ((int) Tools::getValue('entity')) {
            case $this->entities[$this->trans('Combinations', array(), 'Admin.Global')]:
                $this->required_fields = array(
                    'group',
                    'attribute',
                );

                $this->available_fields = array(
                    'no' => array('label' => $this->trans('Ignore this column', array(), 'Admin.Advparameters.Feature')),
                    'id_product' => array('label' => $this->trans('Product ID', array(), 'Admin.Advparameters.Feature')),
                    'product_reference' => array('label' => $this->trans('Product Reference', array(), 'Admin.Advparameters.Feature')),
                    'group' => array(
                        'label' => $this->trans('Attribute (Name:Type:Position)', array(), 'Admin.Advparameters.Feature') . '*',
                    ),
                    'attribute' => array(
                        'label' => $this->trans('Value (Value:Position)', array(), 'Admin.Advparameters.Feature') . '*',
                    ),
                    'supplier_reference' => array('label' => $this->trans('Supplier reference', array(), 'Admin.Advparameters.Feature')),
                    'reference' => array('label' => $this->trans('Reference', array(), 'Admin.Global')),
                    'ean13' => array('label' => $this->trans('EAN13', array(), 'Admin.Advparameters.Feature')),
                    'upc' => array('label' => $this->trans('UPC', array(), 'Admin.Advparameters.Feature')),
                    'wholesale_price' => array('label' => $this->trans('Cost price', array(), 'Admin.Catalog.Feature')),
                    'price' => array('label' => $this->trans('Impact on price', array(), 'Admin.Catalog.Feature')),
                    'ecotax' => array('label' => $this->trans('Ecotax', array(), 'Admin.Catalog.Feature')),
                    'quantity' => array('label' => $this->trans('Quantity', array(), 'Admin.Global')),
                    'minimal_quantity' => array('label' => $this->trans('Minimal quantity', array(), 'Admin.Advparameters.Feature')),
                    'low_stock_threshold' => array('label' => $this->trans('Low stock level', array(), 'Admin.Catalog.Feature')),
                    'low_stock_alert' => array('label' => $this->trans('Send me an email when the quantity is under this level', array(), 'Admin.Catalog.Feature')),
                    'weight' => array('label' => $this->trans('Impact on weight', array(), 'Admin.Catalog.Feature')),
                    'default_on' => array('label' => $this->trans('Default (0 = No, 1 = Yes)', array(), 'Admin.Advparameters.Feature')),
                    'available_date' => array('label' => $this->trans('Combination availability date', array(), 'Admin.Advparameters.Feature')),
                    'image_position' => array(
                        'label' => $this->trans('Choose among product images by position (1,2,3...)', array(), 'Admin.Advparameters.Feature'),
                    ),
                    'image_url' => array('label' => $this->trans('Image URLs (x,y,z...)', array(), 'Admin.Advparameters.Feature')),
                    'image_alt' => array('label' => $this->trans('Image alt texts (x,y,z...)', array(), 'Admin.Advparameters.Feature')),
                    'shop' => array(
                        'label' => $this->trans('ID / Name of shop', array(), 'Admin.Advparameters.Feature'),
                        'help' => $this->trans('Ignore this field if you don\'t use the Multistore tool. If you leave this field empty, the default shop will be used.', array(), 'Admin.Advparameters.Help'),
                    ),
                    'advanced_stock_management' => array(
                        'label' => $this->trans('Advanced Stock Management', array(), 'Admin.Advparameters.Feature'),
                        'help' => $this->trans('Enable Advanced Stock Management on product (0 = No, 1 = Yes)', array(), 'Admin.Advparameters.Help'),
                    ),
                    'depends_on_stock' => array(
                        'label' => $this->trans('Depends on stock', array(), 'Admin.Advparameters.Feature'),
                        'help' => $this->trans('0 = Use quantity set in product, 1 = Use quantity from warehouse.', array(), 'Admin.Advparameters.Help'),
                    ),
                    'warehouse' => array(
                        'label' => $this->trans('Warehouse', array(), 'Admin.Advparameters.Feature'),
                        'help' => $this->trans('ID of the warehouse to set as storage.', array(), 'Admin.Advparameters.Help'),
                    ),
                );

                self::$default_values = array(
                    'reference' => '',
                    'supplier_reference' => '',
                    'ean13' => '',
                    'upc' => '',
                    'wholesale_price' => 0,
                    'price' => 0,
                    'ecotax' => 0,
                    'quantity' => 0,
                    'minimal_quantity' => 1,
                    'low_stock_threshold' => null,
                    'low_stock_alert' => false,
                    'weight' => 0,
                    'default_on' => null,
                    'advanced_stock_management' => 0,
                    'depends_on_stock' => 0,
                    'available_date' => date('Y-m-d'),
                );

                break;

            case $this->entities[$this->trans('Categories', array(), 'Admin.Global')]:
                $this->available_fields = array(
                    'no' => array('label' => $this->trans('Ignore this column', array(), 'Admin.Advparameters.Feature')),
                    'id' => array('label' => $this->trans('ID', array(), 'Admin.Global')),
                    'active' => array('label' => $this->trans('Active (0/1)', array(), 'Admin.Advparameters.Feature')),
                    'name' => array('label' => $this->trans('Name', array(), 'Admin.Global')),
                    'parent' => array('label' => $this->trans('Parent category', array(), 'Admin.Catalog.Feature')),
                    'is_root_category' => array(
                        'label' => $this->trans('Root category (0/1)', array(), 'Admin.Advparameters.Feature'),
                        'help' => $this->trans('A category root is where a category tree can begin. This is used with multistore.', array(), 'Admin.Advparameters.Help'),
                    ),
                    'description' => array('label' => $this->trans('Description', array(), 'Admin.Global')),
                    'meta_title' => array('label' => $this->trans('Meta title', array(), 'Admin.Global')),
                    'meta_keywords' => array('label' => $this->trans('Meta keywords', array(), 'Admin.Global')),
                    'meta_description' => array('label' => $this->trans('Meta description', array(), 'Admin.Global')),
                    'link_rewrite' => array('label' => $this->trans('Rewritten URL', array(), 'Admin.Shopparameters.Feature')),
                    'image' => array('label' => $this->trans('Image URL', array(), 'Admin.Advparameters.Feature')),
                    'shop' => array(
                        'label' => $this->trans('ID / Name of shop', array(), 'Admin.Advparameters.Feature'),
                        'help' => $this->trans('Ignore this field if you don\'t use the Multistore tool. If you leave this field empty, the default shop will be used.', array(), 'Admin.Advparameters.Help'),
                    ),
                );

                self::$default_values = array(
                    'active' => '1',
                    'parent' => Configuration::get('PS_HOME_CATEGORY'),
                    'link_rewrite' => '',
                );

                break;

            case $this->entities[$this->trans('Products', array(), 'Admin.Global')]:
                self::$validators['image'] = array(
                    'AdminImportController',
                    'split',
                );

                $this->available_fields = array(
                    'no' => array('label' => $this->trans('Ignore this column', array(), 'Admin.Advparameters.Feature')),
                    'id' => array('label' => $this->trans('ID', array(), 'Admin.Global')),
                    'active' => array('label' => $this->trans('Active (0/1)', array(), 'Admin.Advparameters.Feature')),
                    'name' => array('label' => $this->trans('Name', array(), 'Admin.Global')),
                    'category' => array('label' => $this->trans('Categories (x,y,z...)', array(), 'Admin.Advparameters.Feature')),
                    'price_tex' => array('label' => $this->trans('Price tax excluded', array(), 'Admin.Advparameters.Feature')),
                    'price_tin' => array('label' => $this->trans('Price tax included', array(), 'Admin.Advparameters.Feature')),
                    'id_tax_rules_group' => array('label' => $this->trans('Tax rule ID', array(), 'Admin.Advparameters.Feature')),
                    'wholesale_price' => array('label' => $this->trans('Cost price', array(), 'Admin.Catalog.Feature')),
                    'on_sale' => array('label' => $this->trans('On sale (0/1)', array(), 'Admin.Advparameters.Feature')),
                    'reduction_price' => array('label' => $this->trans('Discount amount', array(), 'Admin.Advparameters.Feature')),
                    'reduction_percent' => array('label' => $this->trans('Discount percent', array(), 'Admin.Advparameters.Feature')),
                    'reduction_from' => array('label' => $this->trans('Discount from (yyyy-mm-dd)', array(), 'Admin.Advparameters.Feature')),
                    'reduction_to' => array('label' => $this->trans('Discount to (yyyy-mm-dd)', array(), 'Admin.Advparameters.Feature')),
                    'reference' => array('label' => $this->trans('Reference #', array(), 'Admin.Advparameters.Feature')),
                    'supplier_reference' => array('label' => $this->trans('Supplier reference #', array(), 'Admin.Advparameters.Feature')),
                    'supplier' => array('label' => $this->trans('Supplier', array(), 'Admin.Global')),
                    'manufacturer' => array('label' => $this->trans('Brand', array(), 'Admin.Global')),
                    'ean13' => array('label' => $this->trans('EAN13', array(), 'Admin.Advparameters.Feature')),
                    'upc' => array('label' => $this->trans('UPC', array(), 'Admin.Advparameters.Feature')),
                    'ecotax' => array('label' => $this->trans('Ecotax', array(), 'Admin.Catalog.Feature')),
                    'width' => array('label' => $this->trans('Width', array(), 'Admin.Global')),
                    'height' => array('label' => $this->trans('Height', array(), 'Admin.Global')),
                    'depth' => array('label' => $this->trans('Depth', array(), 'Admin.Global')),
                    'weight' => array('label' => $this->trans('Weight', array(), 'Admin.Global')),
                    'delivery_in_stock' => array(
                        'label' => $this->trans(
                            'Delivery time of in-stock products:',
                            array(),
                            'Admin.Catalog.Feature'
                        ),
                    ),
                    'delivery_out_stock' => array(
                        'label' => $this->trans(
                            'Delivery time of out-of-stock products with allowed orders:',
                            array(),
                            'Admin.Advparameters.Feature'
                        ),
                    ),
                    'quantity' => array('label' => $this->trans('Quantity', array(), 'Admin.Global')),
                    'minimal_quantity' => array('label' => $this->trans('Minimal quantity', array(), 'Admin.Advparameters.Feature')),
                    'low_stock_threshold' => array('label' => $this->trans('Low stock level', array(), 'Admin.Catalog.Feature')),
                    'low_stock_alert' => array('label' => $this->trans('Send me an email when the quantity is under this level', array(), 'Admin.Catalog.Feature')),
                    'visibility' => array('label' => $this->trans('Visibility', array(), 'Admin.Catalog.Feature')),
                    'additional_shipping_cost' => array('label' => $this->trans('Additional shipping cost', array(), 'Admin.Advparameters.Feature')),
                    'unity' => array('label' => $this->trans('Unit for the price per unit', array(), 'Admin.Advparameters.Feature')),
                    'unit_price' => array('label' => $this->trans('Price per unit', array(), 'Admin.Advparameters.Feature')),
                    'description_short' => array('label' => $this->trans('Summary', array(), 'Admin.Catalog.Feature')),
                    'description' => array('label' => $this->trans('Description', array(), 'Admin.Global')),
                    'tags' => array('label' => $this->trans('Tags (x,y,z...)', array(), 'Admin.Advparameters.Feature')),
                    'meta_title' => array('label' => $this->trans('Meta title', array(), 'Admin.Global')),
                    'meta_keywords' => array('label' => $this->trans('Meta keywords', array(), 'Admin.Global')),
                    'meta_description' => array('label' => $this->trans('Meta description', array(), 'Admin.Global')),
                    'link_rewrite' => array('label' => $this->trans('Rewritten URL', array(), 'Admin.Advparameters.Feature')),
                    'available_now' => array('label' => $this->trans('Label when in stock', array(), 'Admin.Catalog.Feature')),
                    'available_later' => array('label' => $this->trans('Label when backorder allowed', array(), 'Admin.Advparameters.Feature')),
                    'available_for_order' => array('label' => $this->trans('Available for order (0 = No, 1 = Yes)', array(), 'Admin.Advparameters.Feature')),
                    'available_date' => array('label' => $this->trans('Product availability date', array(), 'Admin.Advparameters.Feature')),
                    'date_add' => array('label' => $this->trans('Product creation date', array(), 'Admin.Advparameters.Feature')),
                    'show_price' => array('label' => $this->trans('Show price (0 = No, 1 = Yes)', array(), 'Admin.Advparameters.Feature')),
                    'image' => array('label' => $this->trans('Image URLs (x,y,z...)', array(), 'Admin.Advparameters.Feature')),
                    'image_alt' => array('label' => $this->trans('Image alt texts (x,y,z...)', array(), 'Admin.Advparameters.Feature')),
                    'delete_existing_images' => array(
                        'label' => $this->trans('Delete existing images (0 = No, 1 = Yes)', array(), 'Admin.Advparameters.Feature'),
                    ),
                    'features' => array('label' => $this->trans('Feature (Name:Value:Position:Customized)', array(), 'Admin.Advparameters.Feature')),
                    'online_only' => array('label' => $this->trans('Available online only (0 = No, 1 = Yes)', array(), 'Admin.Advparameters.Feature')),
                    'condition' => array('label' => $this->trans('Condition', array(), 'Admin.Catalog.Feature')),
                    'customizable' => array('label' => $this->trans('Customizable (0 = No, 1 = Yes)', array(), 'Admin.Advparameters.Feature')),
                    'uploadable_files' => array('label' => $this->trans('Uploadable files (0 = No, 1 = Yes)', array(), 'Admin.Advparameters.Feature')),
                    'text_fields' => array('label' => $this->trans('Text fields (0 = No, 1 = Yes)', array(), 'Admin.Advparameters.Feature')),
                    'out_of_stock' => array('label' => $this->trans('Action when out of stock', array(), 'Admin.Advparameters.Feature')),
                    'is_virtual' => array('label' => $this->trans('Virtual product (0 = No, 1 = Yes)', array(), 'Admin.Advparameters.Feature')),
                    'file_url' => array('label' => $this->trans('File URL', array(), 'Admin.Advparameters.Feature')),
                    'nb_downloadable' => array(
                        'label' => $this->trans('Number of allowed downloads', array(), 'Admin.Catalog.Feature'),
                        'help' => $this->trans('Number of days this file can be accessed by customers. Set to zero for unlimited access.', array(), 'Admin.Catalog.Help'),
                    ),
                    'date_expiration' => array('label' => $this->trans('Expiration date (yyyy-mm-dd)', array(), 'Admin.Advparameters.Feature')),
                    'nb_days_accessible' => array(
                        'label' => $this->trans('Number of days', array(), 'Admin.Advparameters.Feature'),
                        'help' => $this->trans('Number of days this file can be accessed by customers. Set to zero for unlimited access.', array(), 'Admin.Catalog.Help'),
                    ),
                    'shop' => array(
                        'label' => $this->trans('ID / Name of shop', array(), 'Admin.Advparameters.Feature'),
                        'help' => $this->trans('Ignore this field if you don\'t use the Multistore tool. If you leave this field empty, the default shop will be used.', array(), 'Admin.Advparameters.Help'),
                    ),
                    'advanced_stock_management' => array(
                        'label' => $this->trans('Advanced Stock Management', array(), 'Admin.Advparameters.Feature'),
                        'help' => $this->trans('Enable Advanced Stock Management on product (0 = No, 1 = Yes).', array(), 'Admin.Advparameters.Help'),
                    ),
                    'depends_on_stock' => array(
                        'label' => $this->trans('Depends on stock', array(), 'Admin.Advparameters.Feature'),
                        'help' => $this->trans('0 = Use quantity set in product, 1 = Use quantity from warehouse.', array(), 'Admin.Advparameters.Help'),
                    ),
                    'warehouse' => array(
                        'label' => $this->trans('Warehouse', array(), 'Admin.Advparameters.Feature'),
                        'help' => $this->trans('ID of the warehouse to set as storage.', array(), 'Admin.Advparameters.Help'),
                    ),
                    'accessories' => array('label' => $this->trans('Accessories (x,y,z...)', array(), 'Admin.Advparameters.Feature')),
                );

                self::$default_values = array(
                    'id_category' => array((int) Configuration::get('PS_HOME_CATEGORY')),
                    'id_category_default' => null,
                    'active' => '1',
                    'width' => 0.000000,
                    'height' => 0.000000,
                    'depth' => 0.000000,
                    'weight' => 0.000000,
                    'visibility' => 'both',
                    'additional_shipping_cost' => 0.00,
                    'unit_price' => 0,
                    'quantity' => 0,
                    'minimal_quantity' => 1,
                    'low_stock_threshold' => null,
                    'low_stock_alert' => false,
                    'price' => 0,
                    'id_tax_rules_group' => 0,
                    'description_short' => array((int) Configuration::get('PS_LANG_DEFAULT') => ''),
                    'link_rewrite' => array((int) Configuration::get('PS_LANG_DEFAULT') => ''),
                    'online_only' => 0,
                    'condition' => 'new',
                    'available_date' => date('Y-m-d'),
                    'date_add' => date('Y-m-d H:i:s'),
                    'date_upd' => date('Y-m-d H:i:s'),
                    'customizable' => 0,
                    'uploadable_files' => 0,
                    'text_fields' => 0,
                    'advanced_stock_management' => 0,
                    'depends_on_stock' => 0,
                    'is_virtual' => 0,
                );

                break;

            case $this->entities[$this->trans('Customers', array(), 'Admin.Global')]:
                //Overwrite required_fields AS only email is required whereas other entities
                $this->required_fields = array('email', 'passwd', 'lastname', 'firstname');

                $this->available_fields = array(
                    'no' => array('label' => $this->trans('Ignore this column', array(), 'Admin.Advparameters.Feature')),
                    'id' => array('label' => $this->trans('ID', array(), 'Admin.Global')),
                    'active' => array('label' => $this->trans('Active  (0/1)', array(), 'Admin.Advparameters.Feature')),
                    'id_gender' => array('label' => $this->trans('Titles ID (Mr = 1, Ms = 2, else 0)', array(), 'Admin.Advparameters.Feature')),
                    'email' => array('label' => $this->trans('Email', array(), 'Admin.Global') . '*'),
                    'passwd' => array('label' => $this->trans('Password', array(), 'Admin.Global') . '*'),
                    'birthday' => array('label' => $this->trans('Birth date (yyyy-mm-dd)', array(), 'Admin.Advparameters.Feature')),
                    'lastname' => array('label' => $this->trans('Last name', array(), 'Admin.Global') . '*'),
                    'firstname' => array('label' => $this->trans('First name', array(), 'Admin.Global') . '*'),
                    'newsletter' => array('label' => $this->trans('Newsletter (0/1)', array(), 'Admin.Advparameters.Feature')),
                    'optin' => array('label' => $this->trans('Partner offers (0/1)', array(), 'Admin.Advparameters.Feature')),
                    'date_add' => array('label' => $this->trans('Registration date (yyyy-mm-dd)', array(), 'Admin.Advparameters.Feature')),
                    'group' => array('label' => $this->trans('Groups (x,y,z...)', array(), 'Admin.Advparameters.Feature')),
                    'id_default_group' => array('label' => $this->trans('Default group ID', array(), 'Admin.Advparameters.Feature')),
                    'id_shop' => array(
                        'label' => $this->trans('ID / Name of shop', array(), 'Admin.Advparameters.Feature'),
                        'help' => $this->trans('Ignore this field if you don\'t use the Multistore tool. If you leave this field empty, the default shop will be used.', array(), 'Admin.Advparameters.Help'),
                    ),
                );

                self::$default_values = array(
                    'active' => '1',
                    'id_shop' => Configuration::get('PS_SHOP_DEFAULT'),
                );

                break;

            case $this->entities[$this->trans('Addresses', array(), 'Admin.Global')]:
                //Overwrite required_fields
                $this->required_fields = array(
                    'alias',
                    'lastname',
                    'firstname',
                    'address1',
                    'postcode',
                    'country',
                    'customer_email',
                    'city',
                );

                $this->available_fields = array(
                    'no' => array('label' => $this->trans('Ignore this column', array(), 'Admin.Advparameters.Feature')),
                    'id' => array('label' => $this->trans('ID', array(), 'Admin.Global')),
                    'alias' => array('label' => $this->trans('Alias', array(), 'Admin.Shopparameters.Feature') . '*'),
                    'active' => array('label' => $this->trans('Active  (0/1)', array(), 'Admin.Advparameters.Feature')),
                    'customer_email' => array('label' => $this->trans('Customer email', array(), 'Admin.Advparameters.Feature') . '*'),
                    'id_customer' => array('label' => $this->trans('Customer ID', array(), 'Admin.Advparameters.Feature')),
                    'manufacturer' => array('label' => $this->trans('Brand', array(), 'Admin.Global')),
                    'supplier' => array('label' => $this->trans('Supplier', array(), 'Admin.Global')),
                    'company' => array('label' => $this->trans('Company', array(), 'Admin.Global')),
                    'lastname' => array('label' => $this->trans('Last name', array(), 'Admin.Global') . '*'),
                    'firstname' => array('label' => $this->trans('First name ', array(), 'Admin.Global') . '*'),
                    'address1' => array('label' => $this->trans('Address', array(), 'Admin.Global') . '*'),
                    'address2' => array('label' => $this->trans('Address (2)', array(), 'Admin.Global')),
                    'postcode' => array('label' => $this->trans('Zip/postal code', array(), 'Admin.Global') . '*'),
                    'city' => array('label' => $this->trans('City', array(), 'Admin.Global') . '*'),
                    'country' => array('label' => $this->trans('Country', array(), 'Admin.Global') . '*'),
                    'state' => array('label' => $this->trans('State', array(), 'Admin.Global')),
                    'other' => array('label' => $this->trans('Other', array(), 'Admin.Global')),
                    'phone' => array('label' => $this->trans('Phone', array(), 'Admin.Global')),
                    'phone_mobile' => array('label' => $this->trans('Mobile Phone', array(), 'Admin.Global')),
                    'vat_number' => array('label' => $this->trans('VAT number', array(), 'Admin.Orderscustomers.Feature')),
                    'dni' => array('label' => $this->trans('Identification number', array(), 'Admin.Orderscustomers.Feature')),
                );

                self::$default_values = array(
                    'alias' => 'Alias',
                    'postcode' => 'X',
                );

                break;
            case $this->entities[$this->trans('Brands', array(), 'Admin.Global')]:
            case $this->entities[$this->trans('Suppliers', array(), 'Admin.Global')]:
                //Overwrite validators AS name is not MultiLangField
                self::$validators = array(
                    'description' => array('AdminImportController', 'createMultiLangField'),
                    'short_description' => array('AdminImportController', 'createMultiLangField'),
                    'meta_title' => array('AdminImportController', 'createMultiLangField'),
                    'meta_keywords' => array('AdminImportController', 'createMultiLangField'),
                    'meta_description' => array('AdminImportController', 'createMultiLangField'),
                );

                $this->available_fields = array(
                    'no' => array('label' => $this->trans('Ignore this column', array(), 'Admin.Advparameters.Feature')),
                    'id' => array('label' => $this->trans('ID', array(), 'Admin.Global')),
                    'active' => array('label' => $this->trans('Active (0/1)', array(), 'Admin.Advparameters.Feature')),
                    'name' => array('label' => $this->trans('Name', array(), 'Admin.Global')),
                    'description' => array('label' => $this->trans('Description', array(), 'Admin.Global')),
                    'short_description' => array('label' => $this->trans('Short description', array(), 'Admin.Catalog.Feature')),
                    'meta_title' => array('label' => $this->trans('Meta title', array(), 'Admin.Global')),
                    'meta_keywords' => array('label' => $this->trans('Meta keywords', array(), 'Admin.Global')),
                    'meta_description' => array('label' => $this->trans('Meta description', array(), 'Admin.Global')),
                    'image' => array('label' => $this->trans('Image URL', array(), 'Admin.Advparameters.Feature')),
                    'shop' => array(
                        'label' => $this->trans('ID / Name of group shop', array(), 'Admin.Advparameters.Feature'),
                        'help' => $this->trans('Ignore this field if you don\'t use the Multistore tool. If you leave this field empty, the default shop will be used.', array(), 'Admin.Advparameters.Help'),
                    ),
                );

                self::$default_values = array(
                    'shop' => Shop::getGroupFromShop(Configuration::get('PS_SHOP_DEFAULT')),
                );

                break;
            case $this->entities[$this->trans('Alias', array(), 'Admin.Shopparameters.Feature')]:
                //Overwrite required_fields
                $this->required_fields = array(
                    'alias',
                    'search',
                );
                $this->available_fields = array(
                    'no' => array('label' => $this->trans('Ignore this column', array(), 'Admin.Advparameters.Feature')),
                    'id' => array('label' => $this->trans('ID', array(), 'Admin.Global')),
                    'alias' => array('label' => $this->trans('Alias', array(), 'Admin.Shopparameters.Feature') . '*'),
                    'search' => array('label' => $this->trans('Search', array(), 'Admin.Shopparameters.Feature') . '*'),
                    'active' => array('label' => $this->trans('Active', array(), 'Admin.Global')),
                );
                self::$default_values = array(
                    'active' => '1',
                );

                break;
            case $this->entities[$this->trans('Store contacts', array(), 'Admin.Advparameters.Feature')]:
                self::$validators['hours'] = array('AdminImportController', 'split');
                self::$validators['address1'] = array('AdminImportController', 'createMultiLangField');
                self::$validators['address2'] = array('AdminImportController', 'createMultiLangField');

                $this->required_fields = array(
                    'address1',
                    'city',
                    'country',
                    'latitude',
                    'longitude',
                );
                $this->available_fields = array(
                    'no' => array('label' => $this->trans('Ignore this column', array(), 'Admin.Advparameters.Feature')),
                    'id' => array('label' => $this->trans('ID', array(), 'Admin.Global')),
                    'active' => array('label' => $this->trans('Active (0/1)', array(), 'Admin.Advparameters.Feature')),
                    'name' => array('label' => $this->trans('Name', array(), 'Admin.Global')),
                    'address1' => array('label' => $this->trans('Address', array(), 'Admin.Global') . '*'),
                    'address2' => array('label' => $this->trans('Address (2)', array(), 'Admin.Advparameters.Feature')),
                    'postcode' => array('label' => $this->trans('Zip/postal code', array(), 'Admin.Global')),
                    'state' => array('label' => $this->trans('State', array(), 'Admin.Global')),
                    'city' => array('label' => $this->trans('City', array(), 'Admin.Global') . '*'),
                    'country' => array('label' => $this->trans('Country', array(), 'Admin.Global') . '*'),
                    'latitude' => array('label' => $this->trans('Latitude', array(), 'Admin.Advparameters.Feature') . '*'),
                    'longitude' => array('label' => $this->trans('Longitude', array(), 'Admin.Advparameters.Feature') . '*'),
                    'phone' => array('label' => $this->trans('Phone', array(), 'Admin.Global')),
                    'fax' => array('label' => $this->trans('Fax', array(), 'Admin.Global')),
                    'email' => array('label' => $this->trans('Email address', array(), 'Admin.Global')),
                    'note' => array('label' => $this->trans('Note', array(), 'Admin.Advparameters.Feature')),
                    'hours' => array('label' => $this->trans('Hours (x,y,z...)', array(), 'Admin.Advparameters.Feature')),
                    'image' => array('label' => $this->trans('Image URL', array(), 'Admin.Advparameters.Feature')),
                    'shop' => array(
                        'label' => $this->trans('ID / Name of shop', array(), 'Admin.Advparameters.Feature'),
                        'help' => $this->trans('Ignore this field if you don\'t use the Multistore tool. If you leave this field empty, the default shop will be used.', array(), 'Admin.Advparameters.Help'),
                    ),
                );
                self::$default_values = array(
                    'active' => '1',
                );

                break;
        }

        // @since 1.5.0
        if (Configuration::get('PS_ADVANCED_STOCK_MANAGEMENT')) {
            switch ((int) Tools::getValue('entity')) {
                case $this->entities[$this->trans('Supply Orders', array(), 'Admin.Advparameters.Feature')]:
                    // required fields
                    $this->required_fields = array(
                        'id_supplier',
                        'id_warehouse',
                        'reference',
                        'date_delivery_expected',
                    );
                    // available fields
                    $this->available_fields = array(
                        'no' => array('label' => $this->trans('Ignore this column', array(), 'Admin.Advparameters.Feature')),
                        'id' => array('label' => $this->trans('ID', array(), 'Admin.Global')),
                        'id_supplier' => array('label' => $this->trans('Supplier ID *', array(), 'Admin.Advparameters.Feature')),
                        'id_lang' => array('label' => $this->trans('Lang ID', array(), 'Admin.Advparameters.Feature')),
                        'id_warehouse' => array('label' => $this->trans('Warehouse ID *', array(), 'Admin.Advparameters.Feature')),
                        'id_currency' => array('label' => $this->trans('Currency ID *', array(), 'Admin.Advparameters.Feature')),
                        'reference' => array('label' => $this->trans('Supply Order Reference *', array(), 'Admin.Advparameters.Feature')),
                        'date_delivery_expected' => array('label' => $this->trans('Delivery Date (Y-M-D)*', array(), 'Admin.Advparameters.Feature')),
                        'discount_rate' => array('label' => $this->trans('Discount rate', array(), 'Admin.Advparameters.Feature')),
                        'is_template' => array('label' => $this->trans('Template', array(), 'Admin.Advparameters.Feature')),
                    );
                    // default values
                    self::$default_values = array(
                        'id_lang' => (int) Configuration::get('PS_LANG_DEFAULT'),
                        'id_currency' => Currency::getDefaultCurrency()->id,
                        'discount_rate' => '0',
                        'is_template' => '0',
                    );

                    break;
                case $this->entities[$this->trans('Supply Order Details', array(), 'Admin.Advparameters.Feature')]:
                    // required fields
                    $this->required_fields = array(
                        'supply_order_reference',
                        'id_product',
                        'unit_price_te',
                        'quantity_expected',
                    );
                    // available fields
                    $this->available_fields = array(
                        'no' => array('label' => $this->trans('Ignore this column', array(), 'Admin.Advparameters.Feature')),
                        'supply_order_reference' => array('label' => $this->trans('Supply Order Reference *', array(), 'Admin.Advparameters.Feature')),
                        'id_product' => array('label' => $this->trans('Product ID *', array(), 'Admin.Advparameters.Feature')),
                        'id_product_attribute' => array('label' => $this->trans('Product Attribute ID', array(), 'Admin.Advparameters.Feature')),
                        'unit_price_te' => array('label' => $this->trans('Unit Price (tax excl.)*', array(), 'Admin.Advparameters.Feature')),
                        'quantity_expected' => array('label' => $this->trans('Quantity Expected *', array(), 'Admin.Advparameters.Feature')),
                        'discount_rate' => array('label' => $this->trans('Discount Rate', array(), 'Admin.Advparameters.Feature')),
                        'tax_rate' => array('label' => $this->trans('Tax Rate', array(), 'Admin.Advparameters.Feature')),
                    );
                    // default values
                    self::$default_values = array(
                        'discount_rate' => '0',
                        'tax_rate' => '0',
                    );

                    break;
            }
        }

        $this->separator = ($separator = Tools::substr((string) (trim(Tools::getValue('separator'))), 0, 1)) ? $separator : ';';
        $this->convert = false;
        $this->multiple_value_separator = ($separator = Tools::substr((string) (trim(Tools::getValue('multiple_value_separator'))), 0, 1)) ? $separator : ',';
    }
    public static function copyImg($id_entity, $id_image = null, $url = '', $entity = 'products', $regenerate = true)
    {
        $tmpfile = tempnam(_PS_TMP_IMG_DIR_, 'ps_import');
        $watermark_types = explode(',', Configuration::get('WATERMARK_TYPES'));

        switch ($entity) {
            default:
            case 'products':
                $image_obj = new Image($id_image);
                $path = $image_obj->getPathForCreation();

                break;
            case 'categories':
                $path = _PS_CAT_IMG_DIR_ . (int) $id_entity;

                break;
            case 'manufacturers':
                $path = _PS_MANU_IMG_DIR_ . (int) $id_entity;

                break;
            case 'suppliers':
                $path = _PS_SUPP_IMG_DIR_ . (int) $id_entity;

                break;
            case 'stores':
                $path = _PS_STORE_IMG_DIR_ . (int) $id_entity;

                break;
        }

        $url = urldecode(trim($url));
        $parced_url = parse_url($url);

        if (isset($parced_url['path'])) {
            $uri = ltrim($parced_url['path'], '/');
            $parts = explode('/', $uri);
            foreach ($parts as &$part) {
                $part = rawurlencode($part);
            }
            unset($part);
            $parced_url['path'] = '/' . implode('/', $parts);
        }

        if (isset($parced_url['query'])) {
            $query_parts = array();
            parse_str($parced_url['query'], $query_parts);
            $parced_url['query'] = http_build_query($query_parts);
        }

        if (!function_exists('http_build_url')) {
            require_once _PS_TOOL_DIR_ . 'http_build_url/http_build_url.php';
        }

        $url = http_build_url('', $parced_url);

        $orig_tmpfile = $tmpfile;

        if (Tools::copy($url, $tmpfile)) {
            // Evaluate the memory required to resize the image: if it's too much, you can't resize it.
            if (!ImageManager::checkImageMemoryLimit($tmpfile)) {
                @unlink($tmpfile);

                return false;
            }

            $tgt_width = $tgt_height = 0;
            $src_width = $src_height = 0;
            $error = 0;
            ImageManager::resize($tmpfile, $path . '.jpg', null, null, 'jpg', false, $error, $tgt_width, $tgt_height, 5, $src_width, $src_height);
            $images_types = ImageType::getImagesTypes($entity, true);

            if ($regenerate) {
                $previous_path = null;
                $path_infos = array();
                $path_infos[] = array($tgt_width, $tgt_height, $path . '.jpg');
                foreach ($images_types as $image_type) {
                    $tmpfile = self::get_best_path($image_type['width'], $image_type['height'], $path_infos);

                    if (ImageManager::resize(
                        $tmpfile,
                        $path . '-' . stripslashes($image_type['name']) . '.jpg',
                        $image_type['width'],
                        $image_type['height'],
                        'jpg',
                        false,
                        $error,
                        $tgt_width,
                        $tgt_height,
                        5,
                        $src_width,
                        $src_height
                    )) {
                        // the last image should not be added in the candidate list if it's bigger than the original image
                        if ($tgt_width <= $src_width && $tgt_height <= $src_height) {
                            $path_infos[] = array($tgt_width, $tgt_height, $path . '-' . stripslashes($image_type['name']) . '.jpg');
                        }
                        if ($entity == 'products') {
                            if (is_file(_PS_TMP_IMG_DIR_ . 'product_mini_' . (int) $id_entity . '.jpg')) {
                                unlink(_PS_TMP_IMG_DIR_ . 'product_mini_' . (int) $id_entity . '.jpg');
                            }
                            if (is_file(_PS_TMP_IMG_DIR_ . 'product_mini_' . (int) $id_entity . '_' . (int) Context::getContext()->shop->id . '.jpg')) {
                                unlink(_PS_TMP_IMG_DIR_ . 'product_mini_' . (int) $id_entity . '_' . (int) Context::getContext()->shop->id . '.jpg');
                            }
                        }
                    }
                    if (in_array($image_type['id_image_type'], $watermark_types)) {
                        Hook::exec('actionWatermark', array('id_image' => $id_image, 'id_product' => $id_entity));
                    }
                }
            }
        } else {
            @unlink($orig_tmpfile);

            return false;
        }
        unlink($orig_tmpfile);

        return true;
    }
}