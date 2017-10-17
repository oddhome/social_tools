<?php
	$test_members = array();
	$members = array();
	$query = $this->members_model->query_all_active_users();
	if ($query->num_rows())
	{
		foreach ($query->result_array() as $rows) {
			if ($rows['test_group']==1)
			{
				unset($rows['test_group']);
				unset($rows['fb_id']);
				$rows['add'] = '<a href="' .site_url('members/remove_test_member/' .$rows['members_id']). '"><button class="btn btn-danger"><span class="fa fa-trash"></span> Remove</button></a>';
				array_push($test_members,$rows);
			}
			else
			{
				unset($rows['test_group']);
				unset($rows['fb_id']);
				$rows['add'] = '<a href="' .site_url('members/add_test_member/' .$rows['members_id']). '"><button class="btn btn-success"><span class="fa fa-plus"></span> Add</button></a>';
				array_push($members,$rows);
			}
			
		}
	}

	$tmpl = array (
		'table_open'          => '<table class="table table-bordered">',

		'heading_row_start'   => '<tr>',
		'heading_row_end'     => '</tr>',
		'heading_cell_start'  => '<th>',
		'heading_cell_end'    => '</th>',

		'row_start'           => '<tr>',
		'row_end'             => '</tr>',
		'cell_start'          => '<td>',
		'cell_end'            => '</td>',

		'row_alt_start'       => '<tr>',
		'row_alt_end'         => '</tr>',
		'cell_alt_start'      => '<td>',
		'cell_alt_end'        => '</td>',

		'table_close'         => '</table>'
	);

	$this->table->set_template($tmpl);

	$this->table->set_caption('Members for Test Button');
	$this->table->set_heading('ID', 'Email', 'Line User ID', 'Mobile','Create Date','Tools');
	echo $this->table->generate($test_members);


	$this->table->set_caption('Members Other');
	$this->table->set_heading('ID', 'Email', 'Line User ID', 'Mobile','Create Date','Tools');
	echo $this->table->generate($members);
?>