<?php
/*
 * File: GlobalSetterTraits.php
 * Project: Traits
 * Created Date: Mo Nov 2022
 * Author: Ayatulloh Ahad R
 * Email: ayatulloh@indiega.net
 * Phone: 085791555506
 * -------------------------
 * Last Modified: Mon Nov 14 2022
 * Modified By: Ayatulloh Ahad R
 * -------------------------
 * Copyright (c) 2022 Indiega Network 

 * -------------------------
 * HISTORY:
 * Date      	By	Comments 

 * ----------	---	---------------------------------------------------------
 */

namespace Ay4t\Emailhtml\Traits;

trait  GlobalSetterTraits
{
    
    /**
     * template name
     * @var string
     * @author Ayatulloh Ahad R <ayatulloh@indiega.net>
     */
    private $template   = 'default';

    /**
     * @var string
     * @author Ayatulloh Ahad R <ayatulloh@indiega.net>
     */
    protected $filename;

    /**
     * Property data yang akan kita gunakan sebagai penampung data dan dikirim ke view
     * @var array
     * @author Ayatulloh Ahad R <ayatulloh@indiega.net>
     */
    protected $data     = [];

    /**
     * @var string
     * @author Ayatulloh Ahad R <ayatulloh@indiega.net>
     */
    private $template_path;

    /**
     * @var string
     * @author Ayatulloh Ahad R <ayatulloh@indiega.net>
     */
    private $renderHTML;
    

    /**
     * Set the value of template
     *
     * @param string $template
     *
     * @return self
     */ 
    public function setTemplate(string $template)
    {
        $this->template = $template;
        return $this;
    }


    /**
     * Set the value of filename
     *
     * @paramstring$filename
     *
     * @returnself
     */ 
    public function setFilename(string $filename)
    {
        $this->filename = $filename;
        return $this;
    }
}
