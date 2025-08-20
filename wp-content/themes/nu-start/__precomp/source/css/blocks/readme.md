# Gutenberg

This works with Gutenberg. Your CSS will be added as inline styles. All selectors will be prefixed with:
.editor-styles-wrapper (except body, see below).

All the info below is related to using this function with Gutenberg.

# Body Styles

Styles targeting the body will be changed to target .editor-styles-wrapper instead. This lets you to customise the Gutenberg editor pane directly, e.g. to change its padding. You can also set defaults (like font family, color, etc) by adding styles to the body class.

Example: body { color: red } becomes .editor-styles-wrapper { color: red }

# NOTES

- mostly, use .wp-block-blockname
- sometimes use a mixin we have built to only style default (no style chosen)
- sometimes style .is-style-your-style
- soemtimes wrap with .blocks--wrapper to only hit on the front end