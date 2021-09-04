<?php
/**
 * Adds a new post shortcode.
 * @package Windmill
 * @license GPL3.0+
 * @since 1.0.1
*/

/**
 * Inspired by Beans Framework WordPress Theme
 * @link https://www.getbeans.io
 * @author Thierry Muller
 * 
 * Inspired by wordpress_outline WordPress Plugin
 * @link https://github.com/yusukemurayama/blog-samples/blob/master/wordpress_outline/functions.php
 * @author Yusuke Murayama
 * 
 * Inspired by 4536 WordPress Theme
 * @link https://4536.jp
 * @author Shinobi Works
*/


/* Prepare
______________________________
*/

// If this file is called directly,abort.
if(!defined('WPINC')){die;}

// Set identifiers for this template.
// $index = basename(__FILE__,'.php');


/* Exec
______________________________
*/
if(class_exists('_shortcode_toc') === FALSE) :
class _shortcode_toc
{
/**
 * [TOC]
 * 	__get_instance()
 * 	__construct()
 * 	set_param()
 * 	set_hook()
 * 	invoke_hook()
 * 	__the_render()
 * 	get_converted_data()
*/

	/**
		@access (private)
			Class properties.
		@var (string) $_class
			Name/identifier with prefix.
		@var (string) $_index
			Name/identifier without prefix.
		@var (array) $_param
			Parameter for the application.
		@var(array) $hook
			Collection of hooks that is being registered (that is, actions or filters).
	*/
	private static $_class = '';
	private static $_index = '';
	private static $_param = array();
	private $hook = array();

	/**
	 * Traits.
	*/
	use _trait_hook;
	use _trait_singleton;
	use _trait_theme;


	/* Constructor
	_________________________
	*/
	private function __construct()
	{
		/**
			@access (private)
				Class constructor.
				This is only called once, since the only way to instantiate this is with the get_instance() method in trait (singleton.php).
			@return (void)
			@reference
				[Parent]/inc/customizer/option.php
				[Parent]/inc/trait/singleton.php
				[Parent]/inc/utility/general.php
		*/

		// Init properties.
		self::$_class = __utility_get_class(get_class($this));
		self::$_index = __utility_get_index(self::$_class);
		self::$_param = $this->set_param(self::$_index);

		// Register hooks.
		$this->hook = $this->set_hook();
		$this->invoke_hook($this->hook);

	}// Method


	/* Setter
	_________________________
	*/
	private function set_hook()
	{
		/**
			@access (private)
				The collection of hooks that is being registered (that is, actions or filters).
			@return (array)
				_filter[_app_amp][hook]
			@reference
				[Parent]/inc/setup/constant.php
				[Parent]/inc/trait/hook.php
				[Parent]/inc/utility/general.php
		*/
		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);
		$index = self::$_index;

		/**
		 * @reference (Beans)
		 * 	Call the functions added to a filter hook.
		 * 	https://www.getbeans.io/code-reference/functions/beans_apply_filters/
		*/
		return beans_apply_filters("_filter[{$class}][{$function}]",$this->set_parameter_callback(array(
			'__the_render' => array(
				'tag' => 'beans_add_filter',
				'hook' => 'the_content',
				// 'priority' => PRIORITY['default']
				// 'priority' => PRIORITY['max']
				'priority' => 9999999999
			),
		)));

	}// Method


	/* Hook
	_________________________
	*/
	public function __the_render($content)
	{
		/**
			@access (public)
				Echo TOC (table of contents) on posts.
			@param (WP_Post)|(null) $content
				Post Content.
			@return (WP_Post)
				Post Content.
			@reference
				[Parent]/controller/shortcode.php
				[Parent]/inc/customizer/option.php
				[Parent]/inc/utility/general.php
		*/
		if(is_admin()){return $content;}

		$class = self::$_class;
		$function = __utility_get_function(__FUNCTION__);

		// Get current post data.
		// $post = __utility_get_post_object();

		// Get the data of post content.
		// $outline_info = $this->get_converted_data($post->post_content);
		$outline_info = $this->get_converted_data($content);
		if(!$outline_info){return $content;}

		$content = $outline_info['content'];
		$count = $outline_info['count'];
		$outline = $outline_info['outline'];

		if(!$outline){
			return $content;
		}

		/**
		 * @reference (Beans)
		 * 	HTML markup.
		 * 	https://www.getbeans.io/code-reference/functions/beans_output/
		 * @reference (Uikit)
		 * 	https://getuikit.com/docs/card
		 * 	https://getuikit.com/docs/heading
		*/
		$outline = beans_output("_output[{$class}][heading]",sprintf(
			'<div class="uk-card uk-margin uk-padding-small toc"><p class="uk-heading-line uk-text-center"><a href="#"><span>%s</span></a></p>%s</div>',
			self::$_param['title'],
			$outline
		));

		$match = preg_match('/<h[1-6].*>/',$content,$matches,PREG_OFFSET_CAPTURE);
		if($outline && $match){
			$pos = $matches[0][1];
			$content = substr($content,0,$pos) . $outline . substr($content,$pos);
		}
		return $content;

	}// Method


	/**
		@access (private)
		@param (WP_Post)|(null) $content
			Post object.
		@return (array)
			Content data for building TOC.
		@reference
			[Parent]/inc/customizer/option.php
			[Parent]/inc/utility/general.php
	*/
	private function get_converted_data($content)
	{
		if(empty($content)){return array();}

		// 目次のHTMLを入れる変数を定義します。
		$outline = '';

		// h1〜h6タグの個数を入れる変数を定義します。
		$count = 0;

		$search_level = '1-3';
		$search = '/<h([' . $search_level . '])>(.*?)<\/h\1>/';

		/**
		 * @since 1.0.1
		 * 	記事内のh1〜h6タグを検索します。(idやclass属性も含むように改良)
		*/
		if(preg_match_all($search,$content,$matches,PREG_SET_ORDER)){

			$count = count($matches);
			if($count < self::$_param['min']){
				return array(
					'content' => $content,
					'outline' => $outline,
					'count' => $count
				);
			}

			// 記事内で使われているh1〜h6タグの中の、1〜6の中の一番小さな数字を取得します。
			// ※以降ソースの中にある、levelという単語は1〜6のことを表します。
			$min_level = min(array_map(function($m){return $m[1];},$matches));

			// スタート時のlevelを決定します。
			// ※このレベルが上がる毎に、<ul></li>タグが追加されていきます。
			$current_level = $min_level - 1;

			// 各レベルの出現数を格納する配列を定義します。
			$sub_levels = array(
				'1' => 0,
				'2' => 0,
				'3' => 0,
				'4' => 0,
				'5' => 0,
				'6' => 0
			);

			/**
			 * @since 1.0.1
			 * 	記事内で見つかった、hタグの数だけループします。
			*/
			foreach($matches as $m){

				// 見つかったhタグのlevelを取得します。
				$level = $m[1];

				// 見つかったhタグの、タグの中身を取得します。
				$text = strip_tags($m[2]);

				// li, ulタグを閉じる処理です。2ループ目以降に中に入る可能性があります。
				// 例えば、前回処理したのがh3タグで、今回出現したのがh2タグの場合、h3タグ用のulを閉じて、h2タグに備えます。
				while($current_level > $level){
					$current_level--;
					$outline .= '</li></ul>';
				}

				// 同じlevelの場合、liタグを閉じ、新しく開きます。
				if($current_level == $level){
					// $outline .= '</li><li class="outline__item">';
					$outline .= '</li><li class="uk-padding-small uk-padding-remove-bottom">';
				}
				else{
					// 同じlevelでない場合は、ul, liタグを追加していきます。
					// 例えば、前回処理したのがh2タグで、今回出現したのがh3タグの場合、h3タグのためにulを追加します。
					while($current_level < $level){
						$current_level++;
						// $outline .= sprintf('<ul class="outline__list outline__list-%s"><li class="outline__item">',$current_level);
						$outline .= sprintf('<ul class="uk-list outline-list-%s"><li class="uk-padding-small uk-padding-remove-bottom">',$current_level);
					}

					// 見出しのレベルが変わった場合は、現在のレベル以下の出現回数をリセットします。
					for($idx = $current_level + 0; $idx < count($sub_levels); $idx++){
						$sub_levels[$idx] = 0;
					}
				}

				// 各レベルの出現数を格納する配列を更新します。
				$sub_levels[$current_level]++;

				// 現在処理中のhタグの、パスを入れる配列を定義します。
				// 例えば、h2 -> h3 -> h3タグと進んでいる場合は、level_fullpathはarray(1, 2)のようになります。
				// ※level_fullpath[0]の1は、1番目のh2タグの直下に入っていることを表します。
				// ※level_fullpath[1]の2は、2番目のh3を表します。
				$level_fullpath = array();

				for($idx = $min_level; $idx <= $level; $idx++){
					$level_fullpath[] = $sub_levels[$idx];
				}
				$target_anchor = 'outline__' . implode('_', $level_fullpath);

				/**
				 * @since 1.0.1
				 * 	目次に<a href="#outline_1_2">1.2 見出し</a>のような形式で見出しを追加します。
				*/
				// $outline .= sprintf('<a class="outline__link" href="#%s"><span class="outline__number">%s.</span> %s</a>',$target_anchor,implode('.',$level_fullpath),strip_tags($text));
				$outline .= sprintf('<a href="#%s" aria-label="Anchor Link" uk-scroll><span>%s.</span> %s</a>',$target_anchor,implode('.',$level_fullpath),strip_tags($text));
				// 本文中の見出し本体を、<h3>見出し</h3>を<h3 id="outline_1_2">見出し</h3>のような形式で置き換えます。
				$content = preg_replace('/<h([' . $search_level . '])>/','<h\1 id="' . $target_anchor . '">',$content,1);
			}

			$search = '/<h([' . $search_level . '])\s(.*?)>(.*?)<\/h\1>/';
			$content = preg_replace($search,'<h\1><span $2>$3</span></h\1>',$content);

			// hタグのループが終了後、閉じられていないulタグを閉じていきます。
			while($current_level >= $min_level){
				$outline .= '</li></ul>';
				$current_level--;
			}
		}

		return array(
			'content' => $content,
			'outline' => $outline,
			'count' => $count
		);

	}// Method


}// Class
endif;
// new _shortcode_toc();
_shortcode_toc::__get_instance();
