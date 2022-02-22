module.exports = function (grunt) {
  // Project configuration
  grunt.initConfig({
    // optionally read package.json
    pkg: grunt.file.readJSON("package.json"),

    // Metadata
    meta: {
      basePath: "./", // your project path
      srcPath: "./src/", // where you keep your sass files
      deployPath: "./", // where you want your compiled css files
    },

    // info banner
    banner:
      "/*! <%= pkg.name %> - v<%= pkg.version %> - " +
      '<%= grunt.template.today("yyyy-mm-dd") %>\n' +
      '* Copyright (c) <%= grunt.template.today("yyyy") %> ',

    // IMPORTANT: the task configuration
    sass: {
      dist: {
        options: {
          style: "compressed",
        },
        files: {
          // Dictionary of files
          "<%= meta.deployPath %>style.css":
            "<%= meta.srcPath %>/scss/main.scss", // 'destination': 'source'
        },
      },
    },

    // Image minification
    imagemin: {
      dynamic: {
        files: [
          {
            expand: true,
            cwd: "src/",
            src: ["img/*.{png,jpg,gif}"],
            dest: "assets/",
          },
        ],
      },
    },

    // Responsive images
    responsive_images: {
      myTask: {
        options: {
          sizes: [
            {
              name: "sm",
              width: 320,
            },
            {
              name: "md",
              width: 640,
            },
            {
              name: "lg",
              width: 1024,
            },
            {
              name: "xl",
              width: 1500,
            },
            {
              name: "xxl",
              width: 2000,
            },
          ],
        },
        files: [
          {
            expand: true,
            src: ["*_max.{jpg,gif,png}"],
            cwd: "src/img/",
            dest: "assets/img/responsive/",
          },
        ],
      },
    },

    // Terser
    terser: {
      options: {
        // Task-specific options go here.
      },
      dist: {
        files: {
          './assets/js/main.js': ['<%= meta.srcPath %>/js/main.js'],
        }
      },
    },

    // watch all .scss files under the srcPath
    watch: {
      styles: {
        files: ["<%= meta.srcPath %>/**/*.scss"],
        tasks: ["sass"],
      },
      scripts: {
        files: ["<%= meta.srcPath %>/**/*.js"],
        tasks: ["terser"],
      },
    },
  });

  // Load tasks
  grunt.loadNpmTasks("grunt-contrib-sass");
  grunt.loadNpmTasks("grunt-contrib-imagemin");
  grunt.loadNpmTasks("grunt-responsive-images");
  grunt.loadNpmTasks("grunt-terser");
  grunt.loadNpmTasks("grunt-contrib-watch");

  // Default task
  grunt.registerTask("default", ["sass", "imagemin", "terser", "responsive_images"]);
};
