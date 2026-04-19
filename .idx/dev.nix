# To learn more about how to use Nix to configure your environment
# see: https://developers.google.com/idx/guides/customize-idx-env
{ pkgs, ... }: {
  # Which nixpkgs channel to use.
  channel = "stable-24.05"; # or "unstable"
  # Use https://search.nixos.org/packages to find packages
  packages = [
    pkgs.php
  ];
  # Sets environment variables in the workspace
  env = {};
  # Banco de dados MariaDB
  services.mysql = {
    enable = true;
    package = pkgs.mariadb;
  };
  idx = {
    # Search for the extensions you want on https://open-vsx.org/ and use "publisher.id"
    extensions = [
      "google.gemini-cli-vscode-ide-companion"
    ];
    workspace = {
      onCreate = {
        # Open editors for the following files by default, if they exist:
        default.openFiles = ["public/index.php"];
      };
      # Runs when a workspace is (re)started
      onStart = {
        # Processo 1: Inicia o servidor da aplicação
        run-app-server = "php -S localhost:3000 -t public/";

        # Processo 2: Inicia o servidor do phpMyAdmin
        run-phpmyadmin = "php -S localhost:3001 -t phpmyadmin/";

        # Processo 3: Exibe mensagens de boas-vindas
        welcome-message = "echo '🚀 App rodando em http://localhost:3000 | 🐘 phpMyAdmin em http://localhost:3001'";
      };
    };
  };
}
