module.exports = {
  customSyntax: 'postcss-scss',
  extends: ['stylelint-config-standard'],
  plugins: [
    'stylelint-scss',
    'stylelint-no-unsupported-browser-features'
  ],
  rules: {
    'at-rule-no-unknown': null,
    'plugin/no-unsupported-browser-features': [true, {
      severity: 'warning'
    }]
  }
}
