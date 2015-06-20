<?php
/**
 * Crowd funding integration in OXID
 *
 * Copyright (c) 2015 Kai Neuwerth | digidesk.de
 * E-mail: support@digidesk.de
 * http://www.digidesk.de
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to
 * deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 */

/**
 * Metadata version
 */
$sMetadataVersion = '1.1';

/**
 * Module information
 */
$aModule = array(
    'id'          => 'marm_crowdfunding',
    'title'       => 'Crowdfunding for OXID',
    'description' => array(
        'de' => 'Verwandelt Ihren OXID eShop in eine Crowdfunding-Plattform.',
        'en' => 'Turns your OXID eShop into a crowdfunding platform.',
    ),
    'thumbnail'   => 'module.png',
    'version'     => '1.0.0',
    'author'      => 'marmalade GmbH, MÜNSMEDIA GbR, digidesk - media solutions',
    'extend'      => array(
        // frontend controller
        'details' => 'marm/marm_crowdfunding/application/controllers/crowdfunding_details',

        // models
        'oxarticle' => 'marm/marm_crowdfunding/application/models/crowdfunding_oxarticle',
        'oxorder'   => 'marm/marm_crowdfunding/application/models/crowdfunding_oxorder',

        // core files
        'oxemail'   => 'marm/marm_crowdfunding/core/crowdfunding_oxemail',
    ),
    'files' => array(
        // admin controller
        'marm_crowdfunding_setup' => 'marm/marm_crowdfunding/application/controllers/admin/marm_crowdfunding_setup.php',

        // core files
        'marm_crowdfunding'       => 'marm/marm_crowdfunding/core/marm_crowdfunding.php',
    ),
    'templates' => array(
        // email templates
        'email/html/email_crowdfunding_status.tpl'  => 'marm/marm_crowdfunding/application/views/tpl/email/html/email_crowdfunding_status.tpl',
        'email/plain/email_crowdfunding_status.tpl' => 'marm/marm_crowdfunding/application/views/tpl/email/plain/email_crowdfunding_status.tpl',

        // details includes
        'page/details/inc/marm-crowdfunding-explanation.tpl' => 'marm/marm_crowdfunding/application/views/blocks/page/details/inc/marm-crowdfunding-explanation.tpl',
        'page/details/inc/marm-crowdfunding-status.tpl'      => 'marm/marm_crowdfunding/application/views/blocks/page/details/inc/marm-crowdfunding-status.tpl',
        'page/details/inc/marm-crowdfunding-support.tpl'     => 'marm/marm_crowdfunding/application/views/blocks/page/details/inc/marm-crowdfunding-support.tpl',

        // widgets
        'widgets/marm-crowdfunding-widget.tpl'     => 'marm/marm_crowdfunding/application/views/tpl/widgets/marm-crowdfunding-widget.tpl',

        // admin templates
        'marm_crowdfunding_setup.tpl'     => 'marm/marm_crowdfunding/application/views/admin/tpl/marm_crowdfunding_setup.tpl',
    ),
    'blocks' => array(
        array( 'template' => 'page/details/inc/productmain.tpl', 'block' => 'details_productmain_weight', 'file' => '/application/views/blocks/page/details/inc/marm-crowdfunding-status.tpl' ),
        array( 'template' => 'page/details/inc/productmain.tpl', 'block' => 'details_productmain_weight', 'file' => '/application/views/blocks/page/details/inc/marm-crowdfunding-support.tpl' ),
        array( 'template' => 'page/details/inc/productmain.tpl', 'block' => 'details_productmain_weight', 'file' => '/application/views/blocks/page/details/inc/marm-crowdfunding-explanation.tpl' ),
        array( 'template' => 'page/checkout/thankyou.tpl',       'block' => 'checkout_thankyou_partners', 'file' => '/application/views/blocks/page/details/inc/marm-crowdfunding-support.tpl' ),
    ),
    'settings' => array(
        array( 'group' => 'main', 'name' => 'blShowCrowdfundingStatusDetails',  'type' => 'bool', 'value' => '1' ),
        array( 'group' => 'main', 'name' => 'blShowCrowdfundingExplanationDet', 'type' => 'bool', 'value' => '1' ),
        array( 'group' => 'main', 'name' => 'blShowCrowdfundingSupportDetails', 'type' => 'bool', 'value' => '1' ),
        array( 'group' => 'main', 'name' => 'blShowCrowdfundingThankyou',       'type' => 'bool', 'value' => '1' ),
    )
);