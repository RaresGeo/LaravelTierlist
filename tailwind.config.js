module.exports = {
    purge: {
        content: [
            './resources/views/**/*.blade.php',
            './resources/**/*.js',
            './resources/**/*.vue',
        ],
        options: {
            // Row colours come from the DB and are assembled at runtime
            // (bg-{{ colour }}-700), so purge can't see them in source.
            safelist: [
                'bg-green-700',
                'bg-pink-700',
                'bg-purple-700',
                'bg-blue-700',
                'bg-indigo-700',
                'bg-yellow-700',
                'bg-red-700',
            ],
        },
    },
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {},
    },
    variants: {
        extend: {},
    },
    plugins: [],
}