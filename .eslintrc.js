module.exports = {
  parser: '@babel/eslint-parser',
  extends: [
    'eslint-config-standard',
    'plugin:eslint-plugin-compat/recommended'
  ],
  settings: {
    'import/resolver': 'webpack'
  },
  rules: {
    'arrow-parens': ['error', 'as-needed']
  }
}
