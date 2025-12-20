<?php

namespace Olivier\CatppuccinTheme;

use App\Contracts\Plugins\HasPluginSettings;
use App\Traits\EnvironmentWriterTrait;
use Filament\Contracts\Plugin;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Panel;
use Filament\Support\Colors\Color;

class CatppuccinThemePlugin implements HasPluginSettings, Plugin
{
    use EnvironmentWriterTrait;

    public function getId(): string
    {
        return 'catppuccin-theme';
    }

    public const CATPPUCCIN_ROSEWATER = [
        50 => 'oklch(0.974 0.0185 14.29)',
        100 => 'oklch(0.957 0.036 14.29)',
        200 => 'oklch(0.918 0.069 14.29)',
        300 => 'oklch(0.864 0.111 14.29)',
        400 => 'oklch(0.795 0.152 14.29)',
        500 => 'oklch(0.733 0.172 14.29)',
        600 => 'oklch(0.676 0.181 14.29)',
        700 => 'oklch(0.566 0.163 14.29)',
        800 => 'oklch(0.473 0.137 14.29)',
        900 => 'oklch(0.395 0.115 14.29)',
        950 => 'oklch(0.236 0.074 14.29)',
    ];

    public const CATPPUCCIN_FLAMINGO = [
        50 => 'oklch(0.973 0.024 5.49)',
        100 => 'oklch(0.956 0.046 5.49)',
        200 => 'oklch(0.916 0.089 5.49)',
        300 => 'oklch(0.859 0.143 5.49)',
        400 => 'oklch(0.786 0.197 5.49)',
        500 => 'oklch(0.723 0.223 5.49)',
        600 => 'oklch(0.663 0.234 5.49)',
        700 => 'oklch(0.553 0.21 5.49)',
        800 => 'oklch(0.462 0.176 5.49)',
        900 => 'oklch(0.386 0.148 5.49)',
        950 => 'oklch(0.231 0.095 5.49)',
    ];

    public const CATPPUCCIN_PINK = [
        50 => 'oklch(0.973 0.027 353.76)',
        100 => 'oklch(0.955 0.052 353.76)',
        200 => 'oklch(0.915 0.101 353.76)',
        300 => 'oklch(0.857 0.162 353.76)',
        400 => 'oklch(0.782 0.224 353.76)',
        500 => 'oklch(0.717 0.253 353.76)',
        600 => 'oklch(0.656 0.266 353.76)',
        700 => 'oklch(0.547 0.239 353.76)',
        800 => 'oklch(0.457 0.201 353.76)',
        900 => 'oklch(0.382 0.168 353.76)',
        950 => 'oklch(0.229 0.108 353.76)',
    ];

    public const CATPPUCCIN_MAUVE = [
        50 => 'oklch(0.975 0.022 307.36)',
        100 => 'oklch(0.959 0.042 307.36)',
        200 => 'oklch(0.921 0.082 307.36)',
        300 => 'oklch(0.867 0.132 307.36)',
        400 => 'oklch(0.795 0.182 307.36)',
        500 => 'oklch(0.733 0.206 307.36)',
        600 => 'oklch(0.677 0.217 307.36)',
        700 => 'oklch(0.568 0.195 307.36)',
        800 => 'oklch(0.476 0.164 307.36)',
        900 => 'oklch(0.397 0.137 307.36)',
        950 => 'oklch(0.237 0.088 307.36)',
    ];

    public const CATPPUCCIN_RED = [
        50 => 'oklch(0.967 0.025 21.77)',
        100 => 'oklch(0.945 0.048 21.77)',
        200 => 'oklch(0.895 0.093 21.77)',
        300 => 'oklch(0.825 0.149 21.77)',
        400 => 'oklch(0.738 0.206 21.77)',
        500 => 'oklch(0.667 0.233 21.77)',
        600 => 'oklch(0.605 0.245 21.77)',
        700 => 'oklch(0.503 0.221 21.77)',
        800 => 'oklch(0.42 0.185 21.77)',
        900 => 'oklch(0.35 0.155 21.77)',
        950 => 'oklch(0.209 0.1 21.77)',
    ];

    public const CATPPUCCIN_MAROON = [
        50 => 'oklch(0.968 0.023 18.49)',
        100 => 'oklch(0.947 0.044 18.49)',
        200 => 'oklch(0.898 0.085 18.49)',
        300 => 'oklch(0.831 0.137 18.49)',
        400 => 'oklch(0.746 0.189 18.49)',
        500 => 'oklch(0.677 0.214 18.49)',
        600 => 'oklch(0.616 0.225 18.49)',
        700 => 'oklch(0.513 0.202 18.49)',
        800 => 'oklch(0.428 0.169 18.49)',
        900 => 'oklch(0.357 0.142 18.49)',
        950 => 'oklch(0.213 0.092 18.49)',
    ];

    public const CATPPUCCIN_PEACH = [
        50 => 'oklch(0.973 0.022 41.14)',
        100 => 'oklch(0.955 0.043 41.14)',
        200 => 'oklch(0.915 0.083 41.14)',
        300 => 'oklch(0.859 0.134 41.14)',
        400 => 'oklch(0.786 0.185 41.14)',
        500 => 'oklch(0.723 0.209 41.14)',
        600 => 'oklch(0.663 0.22 41.14)',
        700 => 'oklch(0.553 0.198 41.14)',
        800 => 'oklch(0.462 0.166 41.14)',
        900 => 'oklch(0.386 0.139 41.14)',
        950 => 'oklch(0.231 0.089 41.14)',
    ];

    public const CATPPUCCIN_YELLOW = [
        50 => 'oklch(0.983 0.018 92.62)',
        100 => 'oklch(0.973 0.035 92.62)',
        200 => 'oklch(0.949 0.068 92.62)',
        300 => 'oklch(0.913 0.109 92.62)',
        400 => 'oklch(0.866 0.151 92.62)',
        500 => 'oklch(0.824 0.171 92.62)',
        600 => 'oklch(0.779 0.18 92.62)',
        700 => 'oklch(0.653 0.162 92.62)',
        800 => 'oklch(0.546 0.136 92.62)',
        900 => 'oklch(0.456 0.114 92.62)',
        950 => 'oklch(0.273 0.073 92.62)',
    ];

    public const CATPPUCCIN_GREEN = [
        50 => 'oklch(0.976 0.025 152.03)',
        100 => 'oklch(0.96 0.048 152.03)',
        200 => 'oklch(0.924 0.093 152.03)',
        300 => 'oklch(0.873 0.15 152.03)',
        400 => 'oklch(0.803 0.207 152.03)',
        500 => 'oklch(0.743 0.234 152.03)',
        600 => 'oklch(0.684 0.246 152.03)',
        700 => 'oklch(0.572 0.221 152.03)',
        800 => 'oklch(0.478 0.185 152.03)',
        900 => 'oklch(0.399 0.155 152.03)',
        950 => 'oklch(0.239 0.1 152.03)',
    ];

    public const CATPPUCCIN_TEAL = [
        50 => 'oklch(0.979 0.022 185.89)',
        100 => 'oklch(0.965 0.042 185.89)',
        200 => 'oklch(0.933 0.081 185.89)',
        300 => 'oklch(0.886 0.131 185.89)',
        400 => 'oklch(0.822 0.181 185.89)',
        500 => 'oklch(0.765 0.205 185.89)',
        600 => 'oklch(0.708 0.215 185.89)',
        700 => 'oklch(0.593 0.193 185.89)',
        800 => 'oklch(0.496 0.162 185.89)',
        900 => 'oklch(0.414 0.135 185.89)',
        950 => 'oklch(0.248 0.087 185.89)',
    ];

    public const CATPPUCCIN_SKY = [
        50 => 'oklch(0.981 0.019 220.54)',
        100 => 'oklch(0.968 0.037 220.54)',
        200 => 'oklch(0.939 0.072 220.54)',
        300 => 'oklch(0.896 0.116 220.54)',
        400 => 'oklch(0.835 0.16 220.54)',
        500 => 'oklch(0.781 0.181 220.54)',
        600 => 'oklch(0.726 0.19 220.54)',
        700 => 'oklch(0.609 0.171 220.54)',
        800 => 'oklch(0.509 0.143 220.54)',
        900 => 'oklch(0.425 0.12 220.54)',
        950 => 'oklch(0.255 0.077 220.54)',
    ];

    public const CATPPUCCIN_SAPPHIRE = [
        50 => 'oklch(0.98 0.02 230.62)',
        100 => 'oklch(0.967 0.039 230.62)',
        200 => 'oklch(0.937 0.075 230.62)',
        300 => 'oklch(0.892 0.121 230.62)',
        400 => 'oklch(0.829 0.167 230.62)',
        500 => 'oklch(0.774 0.189 230.62)',
        600 => 'oklch(0.718 0.199 230.62)',
        700 => 'oklch(0.601 0.179 230.62)',
        800 => 'oklch(0.502 0.15 230.62)',
        900 => 'oklch(0.419 0.126 230.62)',
        950 => 'oklch(0.251 0.081 230.62)',
    ];

    public const CATPPUCCIN_BLUE = [
        50 => 'oklch(0.978 0.022 243.4)',
        100 => 'oklch(0.963 0.042 243.4)',
        200 => 'oklch(0.93 0.081 243.4)',
        300 => 'oklch(0.881 0.131 243.4)',
        400 => 'oklch(0.814 0.181 243.4)',
        500 => 'oklch(0.756 0.205 243.4)',
        600 => 'oklch(0.698 0.215 243.4)',
        700 => 'oklch(0.584 0.193 243.4)',
        800 => 'oklch(0.488 0.162 243.4)',
        900 => 'oklch(0.407 0.135 243.4)',
        950 => 'oklch(0.244 0.087 243.4)',
    ];

    public const CATPPUCCIN_LAVENDER = [
        50 => 'oklch(0.982 0.018 264.54)',
        100 => 'oklch(0.97 0.035 264.54)',
        200 => 'oklch(0.943 0.068 264.54)',
        300 => 'oklch(0.903 0.109 264.54)',
        400 => 'oklch(0.847 0.151 264.54)',
        500 => 'oklch(0.798 0.171 264.54)',
        600 => 'oklch(0.748 0.18 264.54)',
        700 => 'oklch(0.628 0.162 264.54)',
        800 => 'oklch(0.525 0.136 264.54)',
        900 => 'oklch(0.438 0.114 264.54)',
        950 => 'oklch(0.263 0.073 264.54)',
    ];

    public const CATPPUCCIN_BASE = [
        50 => 'oklch(0.928 0.013 264.7)',  // Text
        100 => 'oklch(0.896 0.011 264.7)', // Subtext1
        200 => 'oklch(0.833 0.01 264.7)',  // Subtext0
        300 => 'oklch(0.781 0.012 264.7)', // Overlay2
        400 => 'oklch(0.697 0.011 264.7)', // Overlay1
        500 => 'oklch(0.609 0.01 264.7)',  // Overlay0
        600 => 'oklch(0.521 0.012 264.7)', // Surface2
        700 => 'oklch(0.408 0.01 264.7)',  // Surface1
        800 => 'oklch(0.308 0.011 264.7)', // Surface0
        900 => 'oklch(0.258 0.01 264.7)',  // Base
        950 => 'oklch(0.232 0.009 264.7)', // Mantle
    ];

public const CATPPUCCIN_MACCHIATO_RED = [
        50 => 'oklch(0.968 0.024 19.82)',
        100 => 'oklch(0.947 0.047 19.82)',
        200 => 'oklch(0.899 0.091 19.82)',
        300 => 'oklch(0.833 0.146 19.82)',
        400 => 'oklch(0.749 0.202 19.82)',
        500 => 'oklch(0.681 0.228 19.82)',
        600 => 'oklch(0.621 0.24 19.82)',
        700 => 'oklch(0.517 0.216 19.82)',
        800 => 'oklch(0.432 0.181 19.82)',
        900 => 'oklch(0.36 0.152 19.82)',
        950 => 'oklch(0.215 0.098 19.82)',
    ];

    public const CATPPUCCIN_MACCHIATO_MAUVE = [
        50 => 'oklch(0.976 0.021 305.15)',
        100 => 'oklch(0.96 0.041 305.15)',
        200 => 'oklch(0.924 0.079 305.15)',
        300 => 'oklch(0.872 0.127 305.15)',
        400 => 'oklch(0.802 0.176 305.15)',
        500 => 'oklch(0.742 0.199 305.15)',
        600 => 'oklch(0.687 0.209 305.15)',
        700 => 'oklch(0.575 0.188 305.15)',
        800 => 'oklch(0.481 0.158 305.15)',
        900 => 'oklch(0.401 0.132 305.15)',
        950 => 'oklch(0.24 0.085 305.15)',
    ];

    public const CATPPUCCIN_MACCHIATO_GREEN = [
        50 => 'oklch(0.977 0.024 150.57)',
        100 => 'oklch(0.962 0.046 150.57)',
        200 => 'oklch(0.927 0.089 150.57)',
        300 => 'oklch(0.878 0.144 150.57)',
        400 => 'oklch(0.811 0.199 150.57)',
        500 => 'oklch(0.753 0.225 150.57)',
        600 => 'oklch(0.696 0.237 150.57)',
        700 => 'oklch(0.582 0.213 150.57)',
        800 => 'oklch(0.486 0.178 150.57)',
        900 => 'oklch(0.406 0.149 150.57)',
        950 => 'oklch(0.243 0.096 150.57)',
    ];

    public const CATPPUCCIN_MACCHIATO_PEACH = [
        50 => 'oklch(0.974 0.021 39.77)',
        100 => 'oklch(0.957 0.041 39.77)',
        200 => 'oklch(0.918 0.079 39.77)',
        300 => 'oklch(0.864 0.127 39.77)',
        400 => 'oklch(0.793 0.176 39.77)',
        500 => 'oklch(0.732 0.199 39.77)',
        600 => 'oklch(0.673 0.209 39.77)',
        700 => 'oklch(0.562 0.188 39.77)',
        800 => 'oklch(0.469 0.158 39.77)',
        900 => 'oklch(0.392 0.132 39.77)',
        950 => 'oklch(0.235 0.085 39.77)',
    ];

    public const CATPPUCCIN_MACCHIATO_SKY = [
        50 => 'oklch(0.982 0.018 218.83)',
        100 => 'oklch(0.969 0.035 218.83)',
        200 => 'oklch(0.941 0.068 218.83)',
        300 => 'oklch(0.899 0.109 218.83)',
        400 => 'oklch(0.841 0.151 218.83)',
        500 => 'oklch(0.79 0.171 218.83)',
        600 => 'oklch(0.737 0.18 218.83)',
        700 => 'oklch(0.618 0.162 218.83)',
        800 => 'oklch(0.516 0.136 218.83)',
        900 => 'oklch(0.431 0.114 218.83)',
        950 => 'oklch(0.258 0.073 218.83)',
    ];

    public const CATPPUCCIN_MACCHIATO_BASE = [
        50 => 'oklch(0.928 0.012 264.7)',  // Text
        100 => 'oklch(0.896 0.01 264.7)',  // Subtext1
        200 => 'oklch(0.846 0.011 264.7)', // Subtext0
        300 => 'oklch(0.794 0.012 264.7)', // Overlay2
        400 => 'oklch(0.71 0.011 264.7)',  // Overlay1
        500 => 'oklch(0.622 0.01 264.7)',  // Overlay0
        600 => 'oklch(0.534 0.012 264.7)', // Surface2
        700 => 'oklch(0.421 0.01 264.7)',  // Surface1
        800 => 'oklch(0.328 0.011 264.7)', // Surface0
        900 => 'oklch(0.275 0.01 264.7)',  // Base
        950 => 'oklch(0.249 0.009 264.7)', // Mantle
    ];

    public const CATPPUCCIN_FRAPPE_RED = [
        50 => 'oklch(0.969 0.023 18.38)',
        100 => 'oklch(0.948 0.045 18.38)',
        200 => 'oklch(0.901 0.087 18.38)',
        300 => 'oklch(0.836 0.14 18.38)',
        400 => 'oklch(0.754 0.193 18.38)',
        500 => 'oklch(0.687 0.218 18.38)',
        600 => 'oklch(0.628 0.229 18.38)',
        700 => 'oklch(0.523 0.206 18.38)',
        800 => 'oklch(0.437 0.173 18.38)',
        900 => 'oklch(0.365 0.145 18.38)',
        950 => 'oklch(0.218 0.093 18.38)',
    ];

    public const CATPPUCCIN_FRAPPE_MAUVE = [
        50 => 'oklch(0.977 0.02 303.69)',
        100 => 'oklch(0.961 0.039 303.69)',
        200 => 'oklch(0.926 0.076 303.69)',
        300 => 'oklch(0.875 0.122 303.69)',
        400 => 'oklch(0.807 0.169 303.69)',
        500 => 'oklch(0.748 0.191 303.69)',
        600 => 'oklch(0.694 0.201 303.69)',
        700 => 'oklch(0.581 0.181 303.69)',
        800 => 'oklch(0.486 0.152 303.69)',
        900 => 'oklch(0.406 0.127 303.69)',
        950 => 'oklch(0.243 0.082 303.69)',
    ];

    public const CATPPUCCIN_FRAPPE_GREEN = [
        50 => 'oklch(0.978 0.023 149.8)',
        100 => 'oklch(0.963 0.044 149.8)',
        200 => 'oklch(0.929 0.085 149.8)',
        300 => 'oklch(0.881 0.138 149.8)',
        400 => 'oklch(0.816 0.191 149.8)',
        500 => 'oklch(0.76 0.216 149.8)',
        600 => 'oklch(0.704 0.227 149.8)',
        700 => 'oklch(0.589 0.204 149.8)',
        800 => 'oklch(0.492 0.171 149.8)',
        900 => 'oklch(0.411 0.143 149.8)',
        950 => 'oklch(0.246 0.092 149.8)',
    ];

    public const CATPPUCCIN_FRAPPE_PEACH = [
        50 => 'oklch(0.975 0.02 38.55)',
        100 => 'oklch(0.958 0.039 38.55)',
        200 => 'oklch(0.92 0.076 38.55)',
        300 => 'oklch(0.867 0.122 38.55)',
        400 => 'oklch(0.798 0.169 38.55)',
        500 => 'oklch(0.739 0.191 38.55)',
        600 => 'oklch(0.681 0.201 38.55)',
        700 => 'oklch(0.569 0.181 38.55)',
        800 => 'oklch(0.476 0.152 38.55)',
        900 => 'oklch(0.397 0.127 38.55)',
        950 => 'oklch(0.238 0.082 38.55)',
    ];

    public const CATPPUCCIN_FRAPPE_SKY = [
        50 => 'oklch(0.983 0.017 217.89)',
        100 => 'oklch(0.97 0.033 217.89)',
        200 => 'oklch(0.943 0.065 217.89)',
        300 => 'oklch(0.902 0.104 217.89)',
        400 => 'oklch(0.846 0.144 217.89)',
        500 => 'oklch(0.797 0.163 217.89)',
        600 => 'oklch(0.745 0.172 217.89)',
        700 => 'oklch(0.625 0.155 217.89)',
        800 => 'oklch(0.522 0.13 217.89)',
        900 => 'oklch(0.436 0.109 217.89)',
        950 => 'oklch(0.261 0.07 217.89)',
    ];

    public const CATPPUCCIN_FRAPPE_BASE = [
        50 => 'oklch(0.928 0.012 264.7)',  
        100 => 'oklch(0.896 0.011 264.7)', 
        200 => 'oklch(0.859 0.01 264.7)',  
        300 => 'oklch(0.807 0.012 264.7)', 
        400 => 'oklch(0.723 0.011 264.7)', 
        500 => 'oklch(0.635 0.01 264.7)',  
        600 => 'oklch(0.547 0.012 264.7)', 
        700 => 'oklch(0.434 0.01 264.7)',  
        800 => 'oklch(0.348 0.011 264.7)',
        900 => 'oklch(0.292 0.01 264.7)',  
        950 => 'oklch(0.265 0.009 264.7)', 
    ];

    public const CATPPUCCIN_GREEN_BASE = [
        50 => 'oklch(0.93 0.013 166.11)',  
        100 => 'oklch(0.898 0.012 166.11)', 
        200 => 'oklch(0.861 0.011 166.11)', 
        300 => 'oklch(0.809 0.013 166.11)', 
        400 => 'oklch(0.725 0.012 166.11)', 
        500 => 'oklch(0.637 0.011 166.11)', 
        600 => 'oklch(0.549 0.013 166.11)', 
        700 => 'oklch(0.436 0.012 166.11)', 
        800 => 'oklch(0.35 0.011 166.11)',  
        900 => 'oklch(0.294 0.013 166.11)', 
        950 => 'oklch(0.267 0.012 166.11)', 
    ];

    public const CATPPUCCIN_PINK_BASE = [
        50 => 'oklch(0.93 0.013 343.24)',  
        100 => 'oklch(0.898 0.012 343.24)', 
        200 => 'oklch(0.861 0.011 343.24)', 
        300 => 'oklch(0.809 0.013 343.24)', 
        400 => 'oklch(0.725 0.012 343.24)', 
        500 => 'oklch(0.637 0.011 343.24)', 
        600 => 'oklch(0.549 0.013 343.24)', 
        700 => 'oklch(0.436 0.012 343.24)', 
        800 => 'oklch(0.35 0.011 343.24)',  
        900 => 'oklch(0.294 0.013 343.24)', 
        950 => 'oklch(0.267 0.012 343.24)', 
    ];

    public const CATPPUCCIN_HONEY_BASE = [
        50 => 'oklch(0.93 0.013 85.87)',   
        100 => 'oklch(0.898 0.012 85.87)',  
        200 => 'oklch(0.861 0.011 85.87)',  
        300 => 'oklch(0.809 0.013 85.87)',  
        400 => 'oklch(0.725 0.012 85.87)',  
        500 => 'oklch(0.637 0.011 85.87)',  
        600 => 'oklch(0.549 0.013 85.87)',  
        700 => 'oklch(0.436 0.012 85.87)',  
        800 => 'oklch(0.35 0.011 85.87)',   
        900 => 'oklch(0.294 0.013 85.87)',  
        950 => 'oklch(0.267 0.012 85.87)',  
    ];

    public const CATPPUCCIN_OCEAN_BASE = [
        50 => 'oklch(0.85 0.04 235)',  
        100 => 'oklch(0.78 0.055 235)', 
        200 => 'oklch(0.7 0.07 235)', 
        300 => 'oklch(0.6 0.09 235)', 
        400 => 'oklch(0.5 0.11 235)', 
        500 => 'oklch(0.42 0.13 235)', 
        600 => 'oklch(0.36 0.145 235)', 
        700 => 'oklch(0.3 0.155 235)', 
        800 => 'oklch(0.25 0.16 235)',  
        900 => 'oklch(0.21 0.165 235)', 
        950 => 'oklch(0.18 0.17 235)', 
    ];

    public const CATPPUCCIN_SKY_BASE = [
        50 => 'oklch(0.98 0.025 220)',  
        100 => 'oklch(0.96 0.035 220)', 
        200 => 'oklch(0.92 0.045 220)', 
        300 => 'oklch(0.87 0.06 220)', 
        400 => 'oklch(0.8 0.08 220)', 
        500 => 'oklch(0.72 0.095 220)', 
        600 => 'oklch(0.64 0.11 220)', 
        700 => 'oklch(0.52 0.12 220)', 
        800 => 'oklch(0.42 0.13 220)',  
        900 => 'oklch(0.35 0.14 220)', 
        950 => 'oklch(0.28 0.15 220)', 
    ];

    public const CATPPUCCIN_TEAL_BASE = [
        50 => 'oklch(0.94 0.035 190)',  
        100 => 'oklch(0.9 0.05 190)', 
        200 => 'oklch(0.85 0.07 190)', 
        300 => 'oklch(0.78 0.095 190)', 
        400 => 'oklch(0.7 0.12 190)', 
        500 => 'oklch(0.62 0.14 190)', 
        600 => 'oklch(0.54 0.155 190)', 
        700 => 'oklch(0.44 0.165 190)', 
        800 => 'oklch(0.36 0.17 190)',  
        900 => 'oklch(0.3 0.175 190)', 
        950 => 'oklch(0.26 0.18 190)', 
    ];

    public const CATPPUCCIN_LAVENDER_BASE = [
        50 => 'oklch(0.93 0.013 270)',  
        100 => 'oklch(0.898 0.012 270)', 
        200 => 'oklch(0.861 0.011 270)', 
        300 => 'oklch(0.809 0.013 270)', 
        400 => 'oklch(0.725 0.012 270)', 
        500 => 'oklch(0.637 0.011 270)', 
        600 => 'oklch(0.549 0.013 270)', 
        700 => 'oklch(0.436 0.012 270)', 
        800 => 'oklch(0.35 0.011 270)',  
        900 => 'oklch(0.294 0.013 270)', 
        950 => 'oklch(0.267 0.012 270)', 
    ];

    public const CATPPUCCIN_FLAMINGO_BASE = [
        50 => 'oklch(0.93 0.013 10)',  
        100 => 'oklch(0.898 0.012 10)', 
        200 => 'oklch(0.861 0.011 10)', 
        300 => 'oklch(0.809 0.013 10)', 
        400 => 'oklch(0.725 0.012 10)', 
        500 => 'oklch(0.637 0.011 10)', 
        600 => 'oklch(0.549 0.013 10)', 
        700 => 'oklch(0.436 0.012 10)', 
        800 => 'oklch(0.35 0.011 10)',  
        900 => 'oklch(0.294 0.013 10)', 
        950 => 'oklch(0.267 0.012 10)', 
    ];

    public const CATPPUCCIN_MAROON_BASE = [
        50 => 'oklch(0.93 0.013 25)',  
        100 => 'oklch(0.898 0.012 25)', 
        200 => 'oklch(0.861 0.011 25)', 
        300 => 'oklch(0.809 0.013 25)', 
        400 => 'oklch(0.725 0.012 25)', 
        500 => 'oklch(0.637 0.011 25)', 
        600 => 'oklch(0.549 0.013 25)', 
        700 => 'oklch(0.436 0.012 25)', 
        800 => 'oklch(0.35 0.011 25)',  
        900 => 'oklch(0.294 0.013 25)', 
        950 => 'oklch(0.267 0.012 25)', 
    ];

    public const CATPPUCCIN_SAPPHIRE_BASE = [
        50 => 'oklch(0.93 0.013 232)',  
        100 => 'oklch(0.898 0.012 232)', 
        200 => 'oklch(0.861 0.011 232)', 
        300 => 'oklch(0.809 0.013 232)', 
        400 => 'oklch(0.725 0.012 232)', 
        500 => 'oklch(0.637 0.011 232)', 
        600 => 'oklch(0.549 0.013 232)', 
        700 => 'oklch(0.436 0.012 232)', 
        800 => 'oklch(0.35 0.011 232)',  
        900 => 'oklch(0.294 0.013 232)', 
        950 => 'oklch(0.267 0.012 232)', 
    ];

    public function register(Panel $panel): void
    {
        $flavor = config('catppuccin-theme.flavor', 'mocha');
        $colors = $this->getFlavorColors($flavor);

        $panel
            ->colors($colors)
            ->darkModeBrandLogo(null)
            ->brandLogo(null);
    }

    public function boot(Panel $panel): void {}

    public function getSettingsForm(): array
    {
        return [
            Select::make('flavor')
                ->label('Default Theme')
                ->helperText('This theme will be applied by default. Users can choose their own theme in their profile.')
                ->required()
                ->options([
                    'mocha' => '🌙 Mocha',
                    'macchiato' => '🌆 Macchiato',
                    'frappe' => '🪴 Frappé',
                    'green' => '🌿 Green Forest',
                    'pink' => '🌸 Pink Dream',
                    'honey' => '🍯 Honey Gold',
                    'lavender' => '💜 Lavender Dream',
                    'flamingo' => '🦩 Flamingo Sunset',
                    'maroon' => '🍷 Maroon Night',
                    'sapphire' => '💎 Sapphire Deep',
                    'sky' => '☁️ Sky Blue (Light)',
                    'ocean' => '🌊 Ocean Blue (Dark)',
                    'teal' => '🌊 Teal Blue (Blue-Green)',
                ])
                ->default(fn () => config('catppuccin-theme.flavor')),
        ];
    }

    public function saveSettings(array $data): void
    {
        $this->writeToEnvironment([
            'CATPPUCCIN_FLAVOR' => $data['flavor'],
        ]);

        Notification::make()
            ->title('Catppuccin flavor updated')
            ->body('The theme will be applied on next page reload.')
            ->success()
            ->send();
    }



    private function getFlavorColors(string $flavor): array
    {
        return match ($flavor) {
            'mocha' => [
                'danger' => self::CATPPUCCIN_RED,
                'gray' => self::CATPPUCCIN_BASE,
                'info' => self::CATPPUCCIN_SKY,
                'primary' => self::CATPPUCCIN_MAUVE,
                'success' => self::CATPPUCCIN_GREEN,
                'warning' => self::CATPPUCCIN_PEACH,
            ],
            'macchiato' => [
                'danger' => self::CATPPUCCIN_MACCHIATO_RED,
                'gray' => self::CATPPUCCIN_MACCHIATO_BASE,
                'info' => self::CATPPUCCIN_MACCHIATO_SKY,
                'primary' => self::CATPPUCCIN_MACCHIATO_MAUVE,
                'success' => self::CATPPUCCIN_MACCHIATO_GREEN,
                'warning' => self::CATPPUCCIN_MACCHIATO_PEACH,
            ],
            'frappe' => [
                'danger' => self::CATPPUCCIN_FRAPPE_RED,
                'gray' => self::CATPPUCCIN_FRAPPE_BASE,
                'info' => self::CATPPUCCIN_FRAPPE_SKY,
                'primary' => self::CATPPUCCIN_FRAPPE_MAUVE,
                'success' => self::CATPPUCCIN_FRAPPE_GREEN,
                'warning' => self::CATPPUCCIN_FRAPPE_PEACH,
            ],
            'green' => [
                'danger' => self::CATPPUCCIN_RED,
                'gray' => self::CATPPUCCIN_GREEN_BASE,
                'info' => self::CATPPUCCIN_TEAL,
                'primary' => self::CATPPUCCIN_GREEN,
                'success' => self::CATPPUCCIN_TEAL,
                'warning' => self::CATPPUCCIN_YELLOW,
            ],
            'pink' => [
                'danger' => self::CATPPUCCIN_RED,
                'gray' => self::CATPPUCCIN_PINK_BASE,
                'info' => self::CATPPUCCIN_MAUVE,
                'primary' => self::CATPPUCCIN_PINK,
                'success' => self::CATPPUCCIN_GREEN,
                'warning' => self::CATPPUCCIN_PEACH,
            ],
            'honey' => [
                'danger' => self::CATPPUCCIN_RED,
                'gray' => self::CATPPUCCIN_HONEY_BASE,
                'info' => self::CATPPUCCIN_SKY,
                'primary' => self::CATPPUCCIN_YELLOW,
                'success' => self::CATPPUCCIN_GREEN,
                'warning' => self::CATPPUCCIN_PEACH,
            ],
            'ocean' => [
                'danger' => self::CATPPUCCIN_RED,
                'gray' => self::CATPPUCCIN_OCEAN_BASE,
                'info' => self::CATPPUCCIN_SKY,
                'primary' => self::CATPPUCCIN_BLUE,
                'success' => self::CATPPUCCIN_TEAL,
                'warning' => self::CATPPUCCIN_PEACH,
            ],
            'sky' => [
                'danger' => self::CATPPUCCIN_RED,
                'gray' => self::CATPPUCCIN_SKY_BASE,
                'info' => self::CATPPUCCIN_BLUE,
                'primary' => self::CATPPUCCIN_SKY,
                'success' => self::CATPPUCCIN_GREEN,
                'warning' => self::CATPPUCCIN_YELLOW,
            ],
            'teal' => [
                'danger' => self::CATPPUCCIN_RED,
                'gray' => self::CATPPUCCIN_TEAL_BASE,
                'info' => self::CATPPUCCIN_SKY,
                'primary' => self::CATPPUCCIN_TEAL,
                'success' => self::CATPPUCCIN_GREEN,
                'warning' => self::CATPPUCCIN_PEACH,
            ],
            'lavender' => [
                'danger' => self::CATPPUCCIN_RED,
                'gray' => self::CATPPUCCIN_LAVENDER_BASE,
                'info' => self::CATPPUCCIN_BLUE,
                'primary' => self::CATPPUCCIN_LAVENDER,
                'success' => self::CATPPUCCIN_GREEN,
                'warning' => self::CATPPUCCIN_PEACH,
            ],
            'flamingo' => [
                'danger' => self::CATPPUCCIN_RED,
                'gray' => self::CATPPUCCIN_FLAMINGO_BASE,
                'info' => self::CATPPUCCIN_PINK,
                'primary' => self::CATPPUCCIN_FLAMINGO,
                'success' => self::CATPPUCCIN_GREEN,
                'warning' => self::CATPPUCCIN_ROSEWATER,
            ],
            'maroon' => [
                'danger' => self::CATPPUCCIN_RED,
                'gray' => self::CATPPUCCIN_MAROON_BASE,
                'info' => self::CATPPUCCIN_PINK,
                'primary' => self::CATPPUCCIN_MAROON,
                'success' => self::CATPPUCCIN_GREEN,
                'warning' => self::CATPPUCCIN_PEACH,
            ],
            'sapphire' => [
                'danger' => self::CATPPUCCIN_RED,
                'gray' => self::CATPPUCCIN_SAPPHIRE_BASE,
                'info' => self::CATPPUCCIN_SKY,
                'primary' => self::CATPPUCCIN_SAPPHIRE,
                'success' => self::CATPPUCCIN_TEAL,
                'warning' => self::CATPPUCCIN_PEACH,
            ],
            default => [
                'danger' => self::CATPPUCCIN_RED,
                'gray' => self::CATPPUCCIN_BASE,
                'info' => self::CATPPUCCIN_SKY,
                'primary' => self::CATPPUCCIN_MAUVE,
                'success' => self::CATPPUCCIN_GREEN,
                'warning' => self::CATPPUCCIN_PEACH,
            ],
        };
    }
}
