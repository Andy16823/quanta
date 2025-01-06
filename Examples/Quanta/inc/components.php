<?php

class Card extends Component
{
    public function render($quanta, $data)
    {
        $template = $quanta->load_template("templates/post-template.php", $data);
        return $template;
    }
}
$quanta->componentHandler->add_component(new Card("card"));

class CardGrid extends Component
{
    public function render($quanta, $data)
    {
        $result = $quanta->databaseHandler->query("SELECT * FROM cards");
        $args = array('cards' => $result);
        $template = $quanta->load_template("templates/post-grid.php", $args);
        return $template;
    }
}
$quanta->componentHandler->add_component(new CardGrid("grid"));

class Navbar extends Component
{
    public function render($quanta, $data)
    {
        $template = $quanta->load_template("templates/navbar.php");
        return $template;
    }
}
$quanta->componentHandler->add_component(new Navbar("navbar"));

class FallbackComponent extends Component
{
    public function render($quanta, $data)
    {
        return "404 - This page dont exist!";
    }
}
$quanta->componentHandler->add_component(new FallbackComponent("fallbackComponent"));

class UserComponent extends Component
{
    public function render($quanta, $data)
    {
        $template = $quanta->load_template("templates/user-entry.php", $quanta->memory->user_data);
        return $template;
    }
}
$quanta->componentHandler->add_component(new UserComponent("user_component"));

class HeroComponent extends Component
{
    public function render($quanta, $data)
    {
        $template = $quanta->load_template("templates/hero.php");
        return $template;
    }
}
$quanta->componentHandler->add_component(new HeroComponent("hero"));

class AboutComponent extends Component
{
    public function render($quanta, $data)
    {
        $template = $quanta->load_template("templates/about-container.php");
        return $template;
    }
}
$quanta->componentHandler->add_component(new AboutComponent("about"));

class FeaturesComponent extends Component
{
    public function render($quanta, $data)
    {
        $template = $quanta->load_template("templates/features.php");
        return $template;
    }
}
$quanta->componentHandler->add_component(new FeaturesComponent("features"));

class GetStartedComponent extends Component
{
    public function render($quanta, $data)
    {
        $template = $quanta->load_template("templates/get-started.php");
        return $template;
    }
}
$quanta->componentHandler->add_component(new GetStartedComponent("get_started"));

class Footer extends Component
{
    public function render($quanta, $data)
    {
        $template = $quanta->load_template("templates/footer.php");
        return $template;
    }
}
$quanta->componentHandler->add_component(new Footer("footer"));