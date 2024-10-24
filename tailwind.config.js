/** @type {import('tailwindcss').Config} */

module.exports = {
    content: [
        "./html/**/*",
    ],
    theme: {
        extend: {
            fontFamily: {
                'cormorant': ['"Cormorant-Bold"'],
                'sans': ['Poppins'],
            },
            fontSize: {
                'small': ['14px'],
                'h1': ['32px'],
                'h2': ['24px'],
                'h3': ['20px'],
                'h4': ['18px'],
                'PACT': ['35px', {
                    letterSpacing: '10px',
                }],
            },
            colors: {
                'rouge-logo':'#EA4335',
                'primary': '#F2771B',
                'secondary': '#00350D',
                'base100': '#F1F3F4',
                'base200': '#E0E0E0',
                'base300': '#CCCCCC',
                'neutre': '#000',
                'gris': '#828282',
                'bgBlur': "#F1F3F4",
                'veryGris': "#BFBFBF", 
            },
            spacing: {
                '1/6': '16%',
            }
        },
    },
    plugins: [],
}
