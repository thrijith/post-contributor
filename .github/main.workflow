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
  uses = "thrijith/github-actions-library@feature/wp-plugin-deploy"
  secrets = ["WORDPRESS_USERNAME", "WORDPRESS_PASSWORD"]
  env = {
    SLUG = "post-contributor"
    CUSTOM_COMMAND = "gulp build"
    CUSTOM_PATH = "post-contributor"
    EXCLUDE_LIST = "post-contributor/asset_sources"
  }
}
