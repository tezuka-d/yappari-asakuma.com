<?php
/**
Template Name: リダイレクト用


 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage noichi
 * @since noichi 1.0
 */

$link = get_field('rlink');

header("Location: {$link}");
exit;
?>


