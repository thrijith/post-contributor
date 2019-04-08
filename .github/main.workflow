workflow "Deploy" {
  resolves = ["WordPress Plugin Deploy"]
  on = "push"
}

# Filter for tag
action "tag" {
    uses = "actions/bin/filter@master"
    args = "tag"
}

action "WordPress Plugin Deploy" {
  needs = ["tag"]
  uses = "thrijith/github-actions-library/wp-plugin-deploy@deploy"
  secrets = ["WORDPRESS_USERNAME", "WORDPRESS_PASSWORD"]
  env = {
    SLUG = "post-contributor"
    CUSTOM_COMMAND = "gulp build"
    EXCLUDE_LIST = "asset_sources .gitignore gulpfile.js package.json package-lock.json node_modules README.md vendor"
  }
}
