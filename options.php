<?php
add_action( 'admin_menu', 'mundoon_simple_taxonomie_filter_menu' );
function mundoon_simple_taxonomie_filter_menu(){
	add_submenu_page(
		'options-general.php',
		'Configurações',
		'Mundoon Filter',
		'manage_options',
		'mundoon-simple-taxonomie-filter',
		'mundoon_simple_taxonomie_filter_page'
	);
}
function mundoon_simple_taxonomie_filter_page() {
	?>
		<div class="wrap">
		<div class="mo-panel-page-header">
			<h1>Mundoon - Simple Taxonomie Filter</h1>
			<h4>Os posts types com mais de uma taxonomia serão listados abaixo:</h4>
		</div>
		<?php
			$cpts = get_post_types(['_builtin'=> false, 'capability_type' => 'post'], 'objects');
			$cpts_infos = [];
			foreach ($cpts as $cpt) {
				$name = $cpt->labels->name;
				$slugs = $cpt->name;
				if ($name != 'Campos' && $name != 'Grupos de Campos') {
					$cpts_infos[$slugs] = $name;
				}
			}
		  ?>  
		<form method="post" action="options.php">
			<?php wp_nonce_field('mo_stf'); ?>
			<?php foreach ($cpts_infos as $key => $label): ?>
				<?php settings_fields('mundoon-stf-options'); ?>
				<?php $mo_stf_option = get_option('mundoon-stf-options'); ?>
				<?php $taxs_cpt = get_object_taxonomies( $key, 'objects' ); ?>
				<?php $n_tax = count($taxs_cpt); ?>
				<?php if ($n_tax > 1): ?>
					<div class="card">
					<h1><?php echo $label; ?></h1>
					<table>
					<?php foreach ($taxs_cpt as $tax) : ?>
						<tr>
							<td>
								<input id="<?php echo $key; ?>-<?php echo $tax->name; ?>" name="mundoon-stf-options[<?php echo $key.'-'.$tax->name; ?>]" type="checkbox" value="1" <?php checked(isset($mo_stf_option[$key.'-'.$tax->name]), 1); ?>>
							</td>
							<td><?php echo $tax->name; ?></td>
							<td>
								<input value="<?php echo $tax->labels->name; ?>" name="mundoon-stf-options[<?php echo $key.'-'.$tax->name.'-label' ?>]" type="text" value="<?php echo $mo_stf_option[$key.'-'.$tax->name.'-label']; ?>" />
							</td>
						</tr>
					<?php endforeach; ?>

					</table>
					<br>
					</div>
					<br>
					<hr>
					<br>
				<?php endif ?>
			<?php endforeach ?>
			<?php submit_button('Salvar', 'button-hero primary'); ?>
		</form>
		</div>
	<?
}
function mundoon_simple_taxonomie_filter_page_register_options(){
	register_setting('mundoon-stf-options', 'mundoon-stf-options');
}
add_action('admin_init', 'mundoon_simple_taxonomie_filter_page_register_options');