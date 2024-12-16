<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class ExerciseSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('exercise')->insert([
            [
                'name' => "Luister Naar De Hand",
                'duration' => 5,
                'minimum_age' => 8,
                'maximum_age' => 18,
                'minimum_players' => 2,
                'water_exercise' => true,
                'description' => "Oefening om de spelers te leren om alert te zijn op situaties waarin de scheidsrechter het spel stopt door op zijn fluit te blazen.  Een speler moet niet alleen leren de fluit te respecteren en gehoorzamen en altijd weten waar de bal is. Voor de hogere leeftijdscategorien komt daar een tactisch element bij: De speler kan ook op de beslissing anticiperen en onmiddellijk dienovereenkomstig handelen. Dit staat bekend als 'heads up' waterpolo en stelt de speler in staat een voorsprong te krijgen op zijn tegenstander of zich snel te herstellen in een verdedigende situatie. Dit scherpe reactievermogen kan worden aangescherpt met de vlag-oefening. Vergeet niet om ook de neutrale worp, of face-off tussen twee spelers, te oefenen. Strafschoten en sprints naar de bal bij de eerste inworp van de scheidsrechter kunnen ook op het fluitsignaal worden geoefend.",
                'procedure' => "Alle teamleden worden aan 1 kant van het zwembad per paar opgesteld. Elk paar is 1 speler aanval, de ander verdeding. Coach staat of loopt langs de kant van het zwembad 1 kant van het zwembad wordt aangewezen als het witte doel, de andere kant als het blauwe doel. Op het fluitsignaal beginnen de spelers te zwemmen (met het hoofd omhoog) naar het doel aan de overkant. Je kan de aanvaller een bal geven voor extra moeilijkheid. Wanneer de fluit klinkt, moeten ze onmiddellijk naar de hand van de coach kijken en dienovereenkomstig reageren in de juiste richting.",
                'image_path' => null,
                'video_path' => null,
                'image_url' => "http://www.waterpoloplanet.com/HTML_Bill_Pages/images/drill_10.01_diagram.gif",
                'video_url' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => "Hete Aardappel",
                'duration' => 10,
                'minimum_age' => 12,
                'maximum_age' => 18,
                'minimum_players' => 5,
                'water_exercise' => true,
                'description' => "Oefening om onder stres de bal snel en nauwkeurig te gooien en meteen klaar te staan om de bal te ontvangen",
                'procedure' => "Rangschik de spelers in verschillende groepen verspreid rond het zwembad (5 of 6 per groep); 1 bal per groep.De spelers vormen een redelijk kleine cirkel en beginnen de bal rond en door de cirkel naar elkaar te passen, waarbij ze proberen de bal niet te lang vast te houden.De coach blaast af en toe op een fluitje. De speler met de bal, of degene die de bal als laatste heeft de bal aangeraakt, moet de cirkel verlaten en een lengte van het zwembad zwemmen (naar de overkant en terug), terwijl de anderen doorgaan met het passen van de bal en anticiperen op het volgende fluitje.Variatie:Elke groep telt het aantal passes dat voltooid is zonder de bal te laten vallen. Als het fluitsignaal gaat, zwemt (of sprint) de hele groep met het laagste aantal passes een lengte van het zwembad zwemmen (naar de overkant en terug)",
                'image_path' => null,
                'video_path' => null,
                'image_url' => "http://www.waterpoloplanet.com/HTML_Bill_Pages/images/drill_2.03_diagram.gif",
                'video_url' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => "Lucht Happen En Ondertrekken",
                'duration' => 5,
                'minimum_age' => 12,
                'maximum_age' => 18,
                'minimum_players' => 2,
                'water_exercise' => true,
                'description' => "Een uitstekende oefening om adem inhouden te trainen en om te leren snel lucht te happen",
                'procedure' => "Maak tweetallen van spelers in diep water, waarbij ze elkaar met de vingers vasthouden terwijl ze elkaar aankijken. Een partner duikt onder totdat hij een gestrekte armpositie bereikt (ongeveer ter hoogte van de knie van de andere partner). De ondergedompelde partner trekt zijn maat onder water, terwijl hij zelf naar boven komt voor een ademteug. Versnel het tempo, waardoor ademen moeilijk wordt. Herhaal dit 10-25 keer.",
                'image_path' => null,
                'video_path' => null,
                'image_url' => "http://www.waterpoloplanet.com/HTML_Bill_Pages/images/drill_1.01_diagram.gif",
                'video_url' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => "Wedstrijdje Onderduwen",
                'duration' => 5,
                'minimum_age' => 10,
                'maximum_age' => 18,
                'minimum_players' => 2,
                'water_exercise' => true,
                'description' => "Een uitstekende allround conditietraining, vooral voor de buik- en rugspieren.",
                'procedure' => "Variatie: Plaats een hand op elkaars hoofd en gebruik de andere arm voor extra ondersteuning in het water.",
                'image_path' => null,
                'video_path' => null,
                'image_url' => "http://www.waterpoloplanet.com/HTML_Bill_Pages/images/drill_1.01_diagram.gif",
                'video_url' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
