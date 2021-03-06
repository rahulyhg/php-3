<form action="<?=Settings::getInstance()->SETTINGS['URL_IDX_SEARCH']; ?>" method="get" class="idx-search">

	<!-- Refine Search -->
	<input type="hidden" name="refine" value="true">

	<!-- Sort Order -->
	<input type="hidden" name="sortorder" value="<?=htmlspecialchars($_REQUEST['sortorder']); ?>">

	<!-- Map Info -->
	<input type="hidden" name="map[longitude]" value="<?=htmlspecialchars($_REQUEST['map']['longitude']); ?>">
	<input type="hidden" name="map[latitude]" value="<?=htmlspecialchars($_REQUEST['map']['latitude']); ?>">
	<input type="hidden" name="map[zoom]" value="<?=htmlspecialchars($_REQUEST['map']['zoom']); ?>">

	<?php

		// Refine Mode
		if ($mode == 'refine') {

			// Top Button
			echo '<div class="btnset"><button type="submit" class="strong">' . $button . '</button></div>';

			// Edit Saved Search
			if (!empty($_REQUEST['edit_search']) && !empty($saved_search)) {
				echo '<input type="hidden" name="edit_search" value="true">';
				echo '<input type="hidden" name="saved_search_id" value="' . $saved_search['id'] . '">';

				// Edit Lead Search
				if (!empty($backend_user) && !empty($lead)) {
					echo '<input type="hidden" name="lead_id" value="' . $lead['id'] . '">';
				}

				// Search Title
				$saved_search['title'] = isset($_REQUEST['search_title']) ? $_REQUEST['search_title'] : $saved_search['title'];

				// Search Frequency
				$saved_search['frequency'] = isset($_REQUEST['frequency']) ? $_REQUEST['frequency'] : $saved_search['frequency'];

				// Search Title
				echo '<div class="field">'
					. '<label>Search Title</label>'
					. '<div class="details">'
						. '<input class="x12" name="search_title" value="' . htmlspecialchars($saved_search['title']) . '" required>'
					. '</div>'
				. '</div>';

				// Search Frequency
				echo '<div class="field">'
					. '<label>Email Frequency</label>'
					. '<div class="details">'
						. '<select name="frequency" class="x12">'
							. '<option value="never"' . ($saved_search['frequency'] == 'never' ? ' selected' : '') . '>Never</option>'
							. '<option value="immediately"' . ($saved_search['frequency'] == 'immediately' ? ' selected' : '') . '>Immediately</option>'
							. '<option value="daily"' . ($saved_search['frequency'] == 'daily' ? ' selected' : '') . '>Daily</option>'
							. '<option value="weekly"' . (empty($saved_search['frequency']) || $saved_search['frequency'] == 'weekly' ? ' selected' : '') . '>Weekly</option>'
							. '<option value="monthly"' . ($saved_search['frequency'] == 'monthly' ? ' selected' : '') . '>Monthly</option>'
						. '</select>'
					. '</div>'
				. '</div>';

			// Create Lead Search
			} elseif (!empty($_REQUEST['create_search']) && !empty($backend_user) && !empty($lead)) {
				echo '<input type="hidden" name="create_search" value="true">';
				echo '<input type="hidden" name="lead_id" value="' . $lead['id'] . '">';

			}

		}

		// Multi-IDX
		if ($this->config['mode'] === 'quicksearch' && !empty(Settings::getInstance()->IDX_FEEDS)) {
			$feeds = '<div class="field qs-feed"><label>Search Area</label><select name="feed" class="x12">';
			foreach (Settings::getInstance()->IDX_FEEDS as $feed => $settings) {
				$selected = Settings::getInstance()->IDX_FEED === $feed ? 'selected' : '';
				$feeds .= '<option ' . $selected . ' value="' . $feed . '">' . $settings['title'] . '</option>';
			}
			$feeds .= '	</select></div>';
			echo $feeds;
		}

		// Display Panels
		foreach ($panels as $panel) {
			$panel->display();
		}

	?>

	<div class="btnset">
		<button type="submit" class="strong"><?=$button; ?></button>
	</div>

</form>