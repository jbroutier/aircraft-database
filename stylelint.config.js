module.exports = {
  customSyntax: 'postcss-scss',
  extends: [
    'stylelint-config-standard'
  ],
  plugins: [
    'stylelint-no-unsupported-browser-features',
    'stylelint-order',
    'stylelint-scss'
  ],
  rules: {
    'at-rule-no-unknown': null,
    'order/properties-alphabetical-order': [true, {
      severity: 'warning'
    }],
    'plugin/no-unsupported-browser-features': [true, {
      severity: 'warning'
    }]
  }
}
