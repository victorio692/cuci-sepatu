const postcss = require('postcss');
const tailwindcss = require('tailwindcss');
const autoprefixer = require('autoprefixer');
const fs = require('fs');
const path = require('path');

const inputCssPath = path.join(__dirname, 'input.css');
const outputCssPath = path.join(__dirname, 'public/assets/css/tailwind.css');

console.log('🔨 Building Tailwind CSS...');
console.log(`📥 Input: ${inputCssPath}`);

const css = fs.readFileSync(inputCssPath, 'utf8');

postcss([tailwindcss, autoprefixer])
  .process(css, { from: inputCssPath, to: outputCssPath })
  .then((result) => {
    fs.writeFileSync(outputCssPath, result.css);
    console.log('✅ Tailwind CSS built successfully!');
    console.log(`📦 Output: ${outputCssPath}`);
    console.log(`📊 Size: ${(result.css.length / 1024).toFixed(2)} KB`);
  })
  .catch((error) => {
    console.error('❌ Error building Tailwind CSS:', error);
    process.exit(1);
  });
