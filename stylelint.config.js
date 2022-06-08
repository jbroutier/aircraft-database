module.exports = {
  customSyntax: 'postcss-scss',
  extends: ['stylelint-config-standard'],
  plugins: [
    'stylelint-scss',
    'stylelint-no-unsupported-browser-features',
    'stylelint-order'
  ],
  rules: {
    'at-rule-no-unknown': null,
    'function-no-unknown': null,
    'plugin/no-unsupported-browser-features': [true, {
      severity: 'warning'
    }],
    'order/properties-alphabetical-order': true
  }
}
