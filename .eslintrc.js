module.exports = {
  env: {
    browser: true
  },
  extends: [
    'eslint-config-standard',
    'plugin:eslint-plugin-compat/recommended'
  ],
  parser: '@babel/eslint-parser',
  rules: {
    'arrow-parens': ['error', 'as-needed']
  },
  settings: {
    'import/resolver': 'webpack'
  }
}
