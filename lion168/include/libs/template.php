<?php
/*
by Filter QQ42248
	1、添加cycle()方法
 */


/*这里是定义类Template*/
class Template
{
	/* 如果设置了，则输出参数 */
	var $classname = "Template";
	var $debug    = false; //是否调试
	var $root     = ".";//root为模板文件的存放目录
	var $file     = array();	//包含了所有的模板文件名和模板名的数组
	var $varkeys  = array();	//存放文本元素的键名
	var $varvals  = array();	//存放文本元素的值
	var $unknowns = "remove";
    /* "remove" => 删除未定义的变量 "comment" => 将未定义的变量变成注释	"keep" => 保留未定义的变量 */
	var $halt_on_error  = "yes";
	/* "yes" => 退出 "report" => 报告错误，继续运行* "no" => 忽略错误*/
	var $last_error     = "";
    /* 上一次的错误保存在这里 */
	/* public: 构造函数
	 *  root: 模板目录
	 *  unknowns: 如何处理未知的变量(译者：变量定义为{name})
	 */

	var $cycle_loop=0;//add by eyes


    /*这里是定义函数Template*/
	function Template($root = ".", $unknowns = "remove")
	{
		if ($this->debug & 4)
		{
			echo "<p><b>模板:</b> root = $root, unknowns = $unknowns</p>\n";
		}
		$this->set_root($root);//默认将文件目录设置为相同的目录
		$this->set_unknowns($unknowns);//unknowns默认设置为"remove"
	}


	/*这里是函数set_root*/
	function set_root($root)
	{
		if ($this->debug & 4)
		{
			echo "<p><b>设置根目录:</b> root = $root</p>\n";
		}
		if (!is_dir($root))
		{
			$this->halt("设置根目录: $root 不是一个无效的目录.");
			return false;
		}
		$this->root = $root;
		return true;
	}


		 //这里是函数set_unknowns,即对未知变量的处理
		 function set_unknowns($unknowns = "remove")
	{
		if ($this->debug & 4)
		{
			echo "<p><b>未知的:</b> 未知 = $unknowns</p>\n";
		}
		$this->unknowns = $unknowns;
	}




	/*这里是函数set_file.......................................................*/
	//该方法在数组file中根据$varname提供的键名加入值
	function set_file($varname, $filename = "")
	{
		if (!is_array($varname))//如果varname是数组
		{
			if ($this->debug & 4)
			{
				echo "<p><b>设置文件:</b> (with scalar) varname = $varname, filename = $filename</p>\n";
			}
			if ($filename == "")//如果文件名为空,输出错误
			{
				$this->halt("设置文件:变量名 $varname 文件名是空的.");
				return false;
			}
			$this->file[$varname] = $this->filename($filename);
		}
		else
		{
			reset($varname);//将varname的键名作为file数组的键名
								//将键名对应的值作为file数组的值
			while(list($v, $f) = each($varname))
			{
				if ($this->debug & 4)
				{
					echo "<p><b>set_file:</b> (with array) varname = $v, filename = $f</p>\n";
				}
				if ($f == "")
				{
					$this->halt("set_file: For varname $v filename is empty.");
					return false;
				}
				$this->file[$v] = $this->filename($f);
			}
		}
		return true;
	}



	//该方法取出某个父模板文件中的一个子模板
	//将其作为块来加载
	//并用另外一个模板变量取代之
	/* public: set_file(array $filelist)
	 * comment: 设置多个模板文件
	 * filelist: （句柄，文件名）数组
	 * public: set_file(string $handle, string $filename)
	 * comment: 设置一个模板文件
	 * handle: 文件的句柄
	 * filename: 模板文件名
	 */
  function set_block($parent, $varname, $name = "") {
    if ($this->debug & 4) {
      echo "<p><b>set_block:</b> parent = $parent, varname = $varname, name = $name</p>\n";
    }
    if (!$this->loadfile($parent)) {
      $this->halt("set_block: unable to load $parent.");
      return false;
    }
    if ($name == "") {
      $name = $varname;//如果没有指定模板变量的值就用子模板名作为模板变量名
    }

    $str = $this->get_var($parent);
    $reg = "/[ \t]*<!--\s+BEGIN $varname\s+-->\s*?\n?(\s*.*?\n?)\s*<!--\s+END $varname\s+-->\s*?\n?/sm";
    preg_match_all($reg, $str, $m);
    $str = preg_replace($reg, "{" . "$name}", $str);
    $this->set_var($varname, $m[1][0]);
    $this->set_var($parent, $str);
    return true;
  }



//该方法向Varname和varkeys数组中添加新的键一值对
	/* public: set_var(array $values)
	 * values: (变量名，值)数组
	 * public: set_var(string $varname, string $value)
	 * varname: 将被定义的变量名
	 * value: 变量的值
	 */
	  function set_var($varname, $value = "", $append = false) {
    if (!is_array($varname))//如果不是阵列
		{
      if (!empty($varname)) //如果是空的
		  {
        if ($this->debug & 1) {
          printf("<b>set_var:</b> (with scalar) <b>%s</b> = '%s'<br>\n", $varname, htmlentities($value));
        }
        $this->varkeys[$varname] = "/".$this->varname($varname)."/";
        if ($append && isset($this->varvals[$varname])) {
          $this->varvals[$varname] .= $value;
        } else {
          $this->varvals[$varname] = $value;
        }
      }
    } else {
      reset($varname);
      while(list($k, $v) = each($varname)) {
        if (!empty($k)) {
          if ($this->debug & 1) {
            printf("<b>set_var:</b> (with array) <b>%s</b> = '%s'<br>\n", $k, htmlentities($v));
          }
          $this->varkeys[$k] = "/".$this->varname($k)."/";
          if ($append && isset($this->varvals[$k])) {
            $this->varvals[$k] .= $v;
          } else {
            $this->varvals[$k] = $v;
          }
        }
      }
    }
  }


//定义函数clear_var
  function clear_var($varname) {
    if (!is_array($varname))//如果varname不是阵列
		{
      if (!empty($varname)) //如果是空的
		  {
        if ($this->debug & 1) {
          printf("<b>clear_var:</b> (with scalar) <b>%s</b><br>\n", $varname);
        }
        $this->set_var($varname, "");
      }
    } else {
      reset($varname);
      while(list($k, $v) = each($varname)) {
        if (!empty($v)) {
          if ($this->debug & 1) {
            printf("<b>clear_var:</b> (with array) <b>%s</b><br>\n", $v);
          }
          $this->set_var($v, "");
        }
      }
    }
  }




/*这里是函数unset_var,删除变量的定义*/
  function unset_var($varname) {
    if (!is_array($varname)) {
      if (!empty($varname)) {
        if ($this->debug & 1) {
          printf("<b>unset_var:</b> (with scalar) <b>%s</b><br>\n", $varname);
        }
        unset($this->varkeys[$varname]);
        unset($this->varvals[$varname]);
      }
    } else {
      reset($varname);
      while(list($k, $v) = each($varname)) {
        if (!empty($v)) {
          if ($this->debug & 1) {
            printf("<b>unset_var:</b> (with array) <b>%s</b><br>\n", $v);
          }
          unset($this->varkeys[$v]);
          unset($this->varvals[$v]);
        }
      }
    }
  }




//将模板文件中的变化内容替换成确定内容的操作,实现数据和显示的分离
  function subst($varname) {
    $varvals_quoted = array();
    if ($this->debug & 4) {
      echo "<p><b>subst:</b> varname = $varname</p>\n";
    }
    if (!$this->loadfile($varname)) //装载模板文件,如果出错就停止
		{
      $this->halt("subst: unable to load $varname.");
      return false;
    }

    reset($this->varvals);
    while(list($k, $v) = each($this->varvals)) {
      $varvals_quoted[$k] = preg_replace(array('/\\\\/', '/\$/'), array('\\\\\\\\', '\\\\$'), $v);
    }

    //读入文件内容到字符串中并在下行对已知键值进行替换并返回结果
    $str = $this->get_var($varname);
    $str = preg_replace($this->varkeys, $varvals_quoted, $str);
    return $str;
  }



//同subst,只是直接输出结果
  function psubst($varname) {
    if ($this->debug & 4) {
      echo "<p><b>psubst:</b> varname = $varname</p>\n";
    }
    print $this->subst($varname);

    return false;
  }



//将varname代表的一个或多个文件中的内容完成替换
//存放在target为键值的varvals数组无素中或追加到其后
//返回值和sub相同
  function parse($target, $varname, $append = false) {
    if (!is_array($varname)) {
      if ($this->debug & 4) {
        echo "<p><b>parse:</b> (with scalar) target = $target, varname = $varname, append = $append</p>\n";
      }
      $str = $this->subst($varname);
      if ($append) {
        $this->set_var($target, $this->get_var($target) . $str);
      } else {
        $this->set_var($target, $str);
      }
    } else {
      reset($varname);
      while(list($i, $v) = each($varname)) {
        if ($this->debug & 4) {
          echo "<p><b>parse:</b> (with array) target = $target, i = $i, varname = $v, append = $append</p>\n";
        }
        $str = $this->subst($v);
        if ($append) {
          $this->set_var($target, $this->get_var($target) . $str);
        } else {
          $this->set_var($target, $str);
        }
      }
    }

    if ($this->debug & 4) {
      echo "<p><b>parse:</b> completed</p>\n";
    }
    return $str;
  }



//同parse方法,只是该方法将结果输出
  function pparse($target, $varname, $append = false) {
    if ($this->debug & 4) {
      echo "<p><b>pparse:</b> passing parameters to parse...</p>\n";
    }
    print $this->finish($this->parse($target, $varname, $append));
    return false;
  }



//返回所有的键一值对中的值所组成的数组
  function get_vars() {
    if ($this->debug & 4) {
      echo "<p><b>get_vars:</b> constructing array of vars...</p>\n";
    }
    reset($this->varkeys);
    while(list($k, $v) = each($this->varkeys)) {
      $result[$k] = $this->get_var($k);
    }
    return $result;
  }



//根据键名返回对应的键一值勤对应的值
  function get_var($varname) {
    if (!is_array($varname)) //如果不是阵列
	{
      if (isset($this->varvals[$varname])) //如果变量不存在
		  {
        $str = $this->varvals[$varname];
      } else {
        $str = "";
      }
      if ($this->debug & 2) {
        printf ("<b>get_var</b> (with scalar) <b>%s</b> = '%s'<br>\n", $varname, htmlentities($str));
      }
      return $str;
    } else {
      reset($varname);
      while(list($k, $v) = each($varname)) {
        if (isset($this->varvals[$v])) {
          $str = $this->varvals[$v];
        } else {
          $str = "";
        }
        if ($this->debug & 2) {
          printf ("<b>get_var:</b> (with array) <b>%s</b> = '%s'<br>\n", $v, htmlentities($str));
        }
        $result[$v] = $str;
      }
      return $result;
    }
  }




//如果加载文件失败,返回错误并停止
  function get_undefined($varname) {
    if ($this->debug & 4) {
      echo "<p><b>get_undefined:</b> varname = $varname</p>\n";
    }
    if (!$this->loadfile($varname)) {
      $this->halt("get_undefined: unable to load $varname.");
      return false;
    }

    preg_match_all("/{([^ \t\r\n}]+)}/", $this->get_var($varname), $m);
    $m = $m[1];
	//如果无法找到匹配的文本,返回错误
    if (!is_array($m)) {
      return false;
    }
//如果能找到大括号中的非空字符,则将其值作为键值,组成一个新的数组
    reset($m);
    while(list($k, $v) = each($m)) {
      if (!isset($this->varkeys[$v])) {
        if ($this->debug & 4) {
         echo "<p><b>get_undefined:</b> undefined: $v</p>\n";
        }
        $result[$v] = $v;
      }
    }
//如是该数组不为空就返回该数组,否则就返回错误
    if (count($result)) {
      return $result;
    } else {
      return false;
    }
  }


//完成对str的最后的处理工作,利用类的属性unknowns来确定对模板中无法处理的动态部分的处理方法
  function finish($str) {
    switch ($this->unknowns) {
      case "keep":  //保持不变
      break;

      case "remove":  //删除所有的非控制符
        $str = preg_replace('/{[^ \t\r\n}]+}/', "", $str);
      break;

      case "comment"://将大括号中的HTML注释
        $str = preg_replace('/{([^ \t\r\n}]+)}/', "<!-- Template variable \\1 undefined -->", $str);
      break;
    }

    return $str;
  }



//将参数变量对诮的数组中的值处理后输出
  function p($varname) {
    print $this->finish($this->get_var($varname));
  }


//将参数变量对应的数组中的值处理后返回
  function get($varname) {
    return $this->finish($this->get_var($varname));
  }



//检查并补充给定的文件名

  function filename($filename) {
    if ($this->debug & 4) {
      echo "<p><b>filename:</b> filename = $filename</p>\n";
    }
    if (substr($filename, 0, 1) != "/")
	//如果文件名不是以斜杠开头,则表示是相对路径,将其补充为完整的绝对路径
	{
      $filename = $this->root."/".$filename;
    }
//如果文件不存在
    if (!file_exists($filename)) {
      $this->halt("filename: file $filename does not exist.");
    }
    return $filename;//返回文件名
  }



//对变量名进行处理,将正则表达式中的敏感字符变为转义字符,并在变量名两端加上大括号
  function varname($varname) {
    return preg_quote("{".$varname."}");
  }


//该方法根据varname加载文件到键一值对中
  function loadfile($varname) {
    if ($this->debug & 4) {
      echo "<p><b>loadfile:</b> varname = $varname</p>\n";
    }

    if (!isset($this->file[$varname])) //如果没有指定就返加错误
		{
      // $varname does not reference a file so return
      if ($this->debug & 4) {
        echo "<p><b>loadfile:</b> varname $varname does not reference a file</p>\n";
      }
      return true;
    }

    if (isset($this->varvals[$varname]))//如果已经加载了varname为名柄的文件,直接返回真值
		{
            if ($this->debug & 4) {
        echo "<p><b>loadfile:</b> varname $varname is already loaded</p>\n";
      }
      return true;
    }
    $filename = $this->file[$varname];//句柄有效则取出对应的文件名
    $str = implode("", @file($filename));//将文件的每一行连接成一个字符串
    if (empty($str)) //字符串空说明文件空或者不存在,返回错误
		{
      $this->halt("loadfile: While loading $varname, $filename does not exist or is empty.");
      return false;
    }
    if ($this->debug & 4) {
      printf("<b>loadfile:</b> loaded $filename into $varname<br>\n");
    }
    $this->set_var($varname, $str);//如果文件不为空,用$varname作为句柄,str为变量名
//向键值对中添加新的键值

    return true;
  }



//出错提示并终止程序运行
  function halt($msg) {
    $this->last_error = $msg;

    if ($this->halt_on_error != "no") {
      $this->haltmsg($msg);
    }

    if ($this->halt_on_error == "yes") {
      die("<b>终止.</b>");
    }

    return false;
  }


//出错提示
  function haltmsg($msg) {
    printf("<b>模板错误:</b> %s<br>\n", $msg);
  }


  /****************************************
   * 函数名：save($dir, $varName)
   *
   * 参  数：$dir:保存到的目录
   *         $varName:保存的文件名
   * 作  者：ccterran
   * 使用例子:
   *				//输出网页,写在文件
   *				$template->parse("out", "handle");
   *				$template->savetofile("index.htm", "out");
   */
   function save($dir, $hnd='out')
   {
     $data = $this->getCon($hnd);
     $fp = fopen($dir, "w+");
     fwrite($fp, $data);
     fclose($fp);
   }

   /**************************
   *返回网页内容
   *2004-8-5
   * by EYES
   * 使用例子:
   *				//输出网页,写在文件
   *				$template->parse("out", "handle");
   *				$conntent = $template->getCon("out");
   **************************/
   function getCon($varname='out')
   {
		return $this->finish($this->get_var($varname));
   }

   /*************************************
    * 函数名：renew()
    *
    * 作  者：ccterran
    */
    function renew()
    {
      $this->varkeys = array();
      $this->varvals = array();
      $this->file = array();
    }

    /*
    获取模板文件中所有标签
    author:eyes
    date:2005.3.1
    */
    function getLabels($hnd)
    {
		if(!isset($this->file[$hnd])) return false;
        if ($fo = @fopen($this->file[$hnd],'r'))
        {
        	$con = fread($fo, filesize($this->file[$hnd]));
        	fclose($fo);
        }
        else
			return false;
        if (preg_match_all("/{([a-zA-Z0-9_\s]+?)}/",$con,$arr))
			return $arr[1];
        else
			return false;
    }//end getLabels

    /*
    循环数据中的内容，相当于smarty中的cycle
    常用用于循环表格行的背景色
	2005.11.8
    */
    function cycle($tpl_tag,$arr_value=null)
    {
		if ($arr_value==null || !is_array($arr_value)) return false;
        if ($this->cycle_loop>=count($arr_value))
        {
			$this->cycle_loop = 0;
        }
		$this->set_var($tpl_tag,$arr_value[$this->cycle_loop]);
		$this->cycle_loop++;

    }

/**************以下为一些原有方法的简写*********************/

	//set_file
	function sf($varname, $filename = "")
	{
	    $this->set_file($varname, $filename);
	}
	//set_var
	function sv($varname, $value = "", $append = false)
	{
	    $this->set_var($varname, $value, $append);
	}
	//set_block
	function sb($parent, $varname)
	{
	    $this->set_block($parent, $varname, $varname.'s');
	}
	//parse block 解析块
    function pb($varname, $append = true)
    {
		$this->parse($varname.'s', $varname, $append);
    }
	//parse
	function ps($target, $varname, $append = false)
	{
	    $this->parse($target, $varname, $append);
	}
	//pparse  注意这里变量的顺序，在一般情况下只需提供"文件句柄"参数就行了
	function pps($varname, $target='out', $append = false)
	{
	    $this->pparse($target, $varname, $append);
	}
/****************end 原有方法的简写****************/
}
?>
