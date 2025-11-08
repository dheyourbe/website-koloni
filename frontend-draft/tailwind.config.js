// tailwind.config.js
module.exports = {
  content: [
    "./index.html",
    "./src/**/*.{js,ts,jsx,tsx}", // sesuaikan dengan struktur project kamu
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          DEFAULT: "#1E1E1E",
          50: "#f5f5f5",
          100: "#e0e0e0",
          200: "#c2c2c2",
          300: "#a3a3a3",
          400: "#858585",
          500: "#666666",
          600: "#4d4d4d",
          700: "#333333",
          800: "#1e1e1e", // base
          900: "#141414",
        },
        secondary: {
          DEFAULT: "#701D0D",
          50: "#fdf3f1",
          100: "#fbe2dd",
          200: "#f6bfb4",
          300: "#f19c8b",
          400: "#e96a4a",
          500: "#d94f2d",
          600: "#b83e20",
          700: "#952f18",
          800: "#701d0d", // base
          900: "#481208",
        },
      },
    },
  },
  plugins: [],
};
