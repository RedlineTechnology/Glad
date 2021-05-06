<?php

/**
 * This file is part of the TextmagicRestClient package.
 *
 * Copyright (c) 2015 TextMagic Ltd. All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace inc\Textmagic\Services\Models; 

 /**
 * @author Denis <denis@textmagic.biz>
 */

class Invoices extends BaseModel {

    protected $resourceName = 'invoices';

    protected $allowMethods = array('getList');

}
