import { registerBlockType } from '@wordpress/blocks';

import * as accordion from '../src/block-library/accordion';
import * as accordion_item from '../src/block-library/accordion-item';

/**
 * Function to register an individual block.
 *
 * @param {Object} block The block to be registered.
 *
 */
const registerBlock = (block) => {
	if (!block) {
		return;
	}

	const { name, settings } = block;

	registerBlockType(name, {
		...settings,
	});
};

const registerBlocks = () => {
	[accordion, accordion_item].forEach(registerBlock);
};
registerBlocks();
