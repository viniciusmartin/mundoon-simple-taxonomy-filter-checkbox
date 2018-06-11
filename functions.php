<?php
function checkbox_filters_simple($tax, $title){
	$options = get_terms( $tax, ['hide_empty' => true] );
	echo "<div class='box-filters' id='box-{$tax}'>";
	echo "<div class='title'><h3>{$title}</h3></div>";
	echo "<div class='lista-filters'>";
	$itens = $_GET[$tax];
	$selecionados = explode(',', $itens);
	foreach ($options as $option) {
		echo "<div><label>";
		echo "<input class='mo-checkbox'  value='{$option->slug}' type='checkbox'"; if(in_array($option->slug, $selecionados)){ echo "checked"; }  ; echo ">";
		echo "<span>{$option->name}</span>";
		echo "</div></label>";
	}
	echo "<input type='hidden'  value='{$itens}' name='{$tax}'>";
	echo "</div>";
	echo "</div>";
}

function mo_stf($cpt=null){
	if ($cpt) {
		$mostf_options = get_option('mundoon-stf-options');
		$filters_check_slugs = [];
		$url = get_bloginfo('url') . '/' . $cpt;
		echo "<div class='mo-filters'>";
		echo "<form id='mo-search' method='get' action='{$url}'>";
		foreach ($mostf_options as $slug => $status) {
			if ($status == 1) {
				array_push($filters_check_slugs, $slug);
			}
		}
		foreach ($filters_check_slugs as $filterslug) {
			$title = $mostf_options[$filterslug.'-label'];
			$poss = strstr($filterslug, $cpt);
			if ($poss) {
				$filter = str_replace($cpt.'-', '', $filterslug);
				checkbox_filters_simple($filter, $title);
			}
		}
		echo "<input type='hidden'>";
		echo "</form>";
		echo "</div>";
	}else{
		echo "Você precisa passar o nome do post type como parâmetro da função. Exemplo: mo_stf('cpt_name')";
	}
}
