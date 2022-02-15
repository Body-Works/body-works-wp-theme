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

    // watch all .scss files under the srcPath
    watch: {
      scripts: {
        files: ["<%= meta.srcPath %>/**/*.scss"],
        tasks: ["sass"],
      },
    },
  });

  // Load tasks
  grunt.loadNpmTasks("grunt-contrib-sass");
  grunt.loadNpmTasks("grunt-contrib-watch");

  // Default task
  grunt.loadNpmTasks("default", ["sass"]);
};
