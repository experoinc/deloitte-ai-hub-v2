<?php

/*
Template Name: HomeTemplate
*/

get_header(); ?>
<?php
function getHeroTexts($id)
{
    // 4 = learn 
    // 21 = explore 
    // 10 = apply
    // 16 = connect
    switch ($id) {
        case 4:
            $hero = (object) [
                'title' => 'Learn',
                'desc' => 'Trainings & other resources that enable you to develop technical skills aournd AI.',
                'hero' => '/wordpress/wp-content/uploads/2022/11/learnicon.png'
            ];
            return $hero;
        case 10:
            $hero = (object) [
                'title' => 'Apply',
                'desc' => 'Links to resources and forums that enable you to explore opportunities to apply you AI skill and connect to others in the firm who are working in AI.',
                'hero' => '/wordpress/wp-content/uploads/2022/11/applyicon.png'
            ];
            return $hero;
        case 21:
            $hero = (object) [
                'title' => 'Explore',
                'desc' => "Find resources that enable you to advance your understanding of Deloitte's approach to AI and learn about our current work.",
                'hero' => '/wordpress/wp-content/uploads/2022/11/exploreicon.png'
            ];
            return $hero;
        case 16:
            $hero = (object) [
                'title' => 'Connect',
                'desc' => "Discover platforms where you can share what you've learned through mentorship, teaching, and eminence opportunities",
                'hero' => '/wordpress/wp-content/uploads/2022/11/connecticon.png'
            ];
            return $hero;
    };
}
?>
<div class="relative overflow-hidden bg-no-repeat bg-cover" style="
    background-position: 50%;
    background-image: url(/wordpress/wp-content/uploads/2022/11/Home-1.png);
    height: 350px;">
    <div class="absolute top-0 right-0 bottom-0 left-0 w-full h-full overflow-hidden bg-fixed">
        <div class="gm-container flex items-center h-full">
            <div class="text-black md:px-12 !pl-0">
                <h1 class="text-6xl font-light mt-0 mb-9">Welcome to AI Hub</h1>
                <h3 class="text-base font-normal mb-8">Navigate a number of curated resources to help you <b>learn</b> new skills<br>relevant to AI; <b>apply</b> your skills in various opportunities; <b>explore</b> Deloitte's<br> approach and current work in AI; and <b>connect</b> with others.</h3>
            </div>
        </div>
    </div>
</div>
<div class="gm-container flex divide-x-2 mt-10">
    <div class="flex flex-col">
        <h2 class="text-4xl">What would you like to do?</h2>
        <p class="py-9">Our guiding pillars are here to help you find the right resources and achieve your goals.</p>
        <div class="flex gap-4 flex-wrap">
            <?php
            $categories = get_categories(
                array('parent' => $cat->cat_ID)
            );
            foreach ($categories as $cat) {
                $data = getHeroTexts($cat->cat_ID);
                $pillar = '<div class="transform cursor-pointer flex flex-col border h-[292px] w-80 min-w-[370px] p-4 border-gray-400 hover:border-gray-600 rounded-md"><img class="w-12 mb-3" src="' . $data->hero . '"><a class="text-3xl font-semibold mb-4" href="/'. strtolower($cat->cat_name) .'">' . $cat->cat_name . '</a><p>' . $data->desc . '</p></div>';
                echo $pillar;
            }
            ?>
        </div>
    </div>
    <div class="px-6">
        <h2 class="text-4xl mb-8">Stay up to date</h2>
        <p class="mb-4">Find the latest announcements and hightlights here.</p>
        <div class="carousel-announcements mt-10">
            <div class="flex flex-col border h-[330px] w-80 min-w-[370px] p-6 border-gray-400 rounded-md items-start">
                <h4 class="text-3xl font-semibold mb-4">What's AI?</h4>
                <p class="text-base">Looking for some extra guidance on what exactly AI is and what it looks like at Deloitte?<br>Foillow the link below to access some AI SGO KX resource and kickstart your AI journey.</p>
                <button class="mt-5 border-[#56D23B] border rounded-md p-3 text-[#56D23B] uppercase text-sm py-2">Learn about AI</button>
            </div>
        </div>
    </div>
</div>
<div class="gm-container my-24">
    <h2 class="text-4xl font-light w-1/2">Your one-stop-shop for growing your career in AI.</h2>
    <article class="max-w-lg text-base">The AI hub grew from practitioner requests for a better way to find AI resources around the firm. In March 2022, we launched a microsite designed to help practitioners navigate to the resources they need. wherever they are in their AI journey.<br><br>Reach out to us at <a class="italic text-blue-600" href="mailto:mygpsaihub@deloitte.com">MyGPSAIHub@deloitte.com</a> if you'd like to see your resource added to the Hub or have general questions about navigating the AI landscape at Deloitte!<br><br>For questions regarding the individual items included on the site, please reach out to the relevant resource owners.</article>
</div>
<div class="flex bg-gray-600 text-white">
    <div class="gm-container my-24">
        <h2 class="text-4xl font-light w-1/2 min-w-[687px]">New to AI? Start here.</h2>
        <div class="max-w-lg">
            <article class="text-base">if you need some extra guidance on what exactly AI is and what it looks like at Deloitte, follow the link below to access some AI SGO KX resources and kickstart your AI journey.</article>
            <button class="mt-5 uppercase bg-[#43B02A] rounded-md text-white px-4 py-2 transform hover:bg-[#56d23b]">learn about ai</button>
        </div>
    </div>
</div>
<?php
get_footer();
