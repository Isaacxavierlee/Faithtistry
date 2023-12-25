{ pkgs }: {
  deps = [
    pkgs.nodePackages.prettier
    pkgs.php82Packages.composer
    pkgs.nodePackages.vscode-langservers-extracted
    pkgs.nodePackages.typescript-language-server  
  ];
}