<?php
require_once '../autoload.php';
use phpOlap\Xmla\Connection\Connection;
use phpOlap\Xmla\Connection\Adaptator\SoapAdaptator;

// for Mondrian
// $connection = new Connection(
//     new SoapAdaptator('http://localhost:8080/mondrian/xmla'),
//     array(
//             'DataSourceInfo' => 'Provider=Mondrian;DataSource=MondrianFoodMart;'
//             'CatalogName' => 'FoodMart',
//             'schemaName' => 'FoodMart'
//         )
// );
// for Microsoft SQL Server Analysis Services

$connection = new Connection(
    new SoapAdaptator('http://10.10.50.74/OLAP/msmdpump.dll', 'winuser', 'revivo2011'),
    array(
        'DataSourceInfo' => null,
        'CatalogName' => 'Adventure Works DW 2008R2 SE'
        )
);


$cube = $connection->findOneCube(null, array('CUBE_NAME' => 'Sales'));

?>


<p><label>Cube :</label> <?php echo $cube->getName() ?></p>
<ul id="cubeExploration">
    <li class="measure">
        Measures
        <ul>
            <?php foreach ($cube->getMeasures() as $measure): ?>
                <li><?php echo $measure->getCaption() ?></li>
            <?php endforeach ?>
        </ul>
    </li>       
    <?php foreach ($cube->getDimensionsAndHierarchiesAndLevels() as $dimention): ?>
        <?php if($dimention->getType() != 'MEASURE') : ?>
        <li>
            <?php echo $dimention->getCaption() ?>
            <ul>
                <?php foreach ($dimention->getHierarchies() as $hierarchy): ?>
                    <li>
                        <?php echo $hierarchy->getCaption() ?>
                        <ul>
                            <?php foreach ($hierarchy->getLevels() as $level): ?>
                                <li>
                                    <?php echo $level->getCaption() ?>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </li>
                <?php endforeach ?>
            </ul>
        </li>
        <?php endif; ?>
    <?php endforeach ?>
</ul>