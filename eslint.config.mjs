// import path from "path";
// import { fileURLToPath } from "url";
// import { FlatCompat } from "@eslint/eslintrc";
import globals from "globals";
// import jsPlugin from "@eslint/js";
// import tsPlugin from "@typescript-eslint/eslint-plugin";
import tsParser from "@typescript-eslint/parser";

// // Mimic CommonJS variables (not needed if using CommonJS)
// const __filename = fileURLToPath(import.meta.url);
// const __dirname = path.dirname(__filename);

// const compat = new FlatCompat({
//   baseDirectory: __dirname,
// });

/** @type {import('eslint').Linter.FlatConfig[]} */
export default [
  {
    files: ["**/*.{mjs,cjs,ts}"],
    languageOptions: {
      parser: tsParser, // Use TypeScript parser for .ts files
      parserOptions: {
        ecmaVersion: "latest",
        sourceType: "commonjs", // Use ES modules
        project: "./tsconfig.json", // TypeScript project
      },
      globals: globals.browser, // Use browser global variables
    },
    // Combining ESLint configurations for JavaScript and TypeScript
    // ...compat.extends("plugin:@eslint/js/recommended"),
    // ...compat.extends("plugin:@typescript-eslint/recommended"),

    // Custom rules
    rules: {
      "semi": ["error", "always"],
      "quotes": ["error", "double"],
      "brace-style": ["warn", "allman"],
      "no-const-assign": "error",
      "no-dupe-else-if": "warn",
      "no-dupe-keys": "error",
      "no-duplicate-case": "error",
      "no-duplicate-imports": "error",
      "no-empty-pattern": "error",
      "no-irregular-whitespace": "warn",
      "no-self-compare": "warn",
      "no-unused-vars": "error",
      "no-use-before-define": "error",
      "arrow-body-style": "warn",
      "block-scoped-var": "warn",
      "capitalized-comments": "warn",
      "class-methods-use-this": "warn",
      "default-case": "warn",
      "default-case-last": "warn",
      "no-continue": "error",
      "no-empty": "error",
      "no-empty-function": "error",
    },
  },
];
