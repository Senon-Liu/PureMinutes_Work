<?php 

/*
* This file is part of phpOlap.
*
* (c) Julien Jacottet <jjacottet@gmail.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace phpOlap\Tests\Layout\Table;

use phpOlap\Xmla\Metadata\ResultSet;
use phpOlap\Layout\Table\HtmlTableLayout;

class HtmlTableLayoutTest extends \PHPUnit_Framework_TestCase
{
    public function test1Col1Row()
    {
		$test = $this->generateTable('resultSet1.xml');
		
		$result = '<table class="olapGrid"><thead><tr><th class="empty" rowspan="1" colspan="1"></th><th colspan="1">Measures</th></tr><tr><th rowspan="">Promotion Media</th><th colspan="1">Unit Sales</th></tr></thead><tbody><tr class="even"><th rowspan="1">&nbsp;&nbsp; Bulk Mail</th><td>4,320</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp; Cash Register Handout</th><td>6,697</td></tr><tr class="even"><th rowspan="1">&nbsp;&nbsp; Daily Paper</th><td>7,738</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp; Daily Paper, Radio</th><td>6,891</td></tr><tr class="even"><th rowspan="1">&nbsp;&nbsp; Daily Paper, Radio, TV</th><td>9,513</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp; In-Store Coupon</th><td>3,798</td></tr><tr class="even"><th rowspan="1">&nbsp;&nbsp; No Media</th><td>195,448</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp; Product Attachment</th><td>7,544</td></tr><tr class="even"><th rowspan="1">&nbsp;&nbsp; Radio</th><td>2,454</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp; Street Handout</th><td>5,753</td></tr><tr class="even"><th rowspan="1">&nbsp;&nbsp; Sunday Paper</th><td>4,339</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp; Sunday Paper, Radio</th><td>5,945</td></tr><tr class="even"><th rowspan="1">&nbsp;&nbsp; Sunday Paper, Radio, TV</th><td>2,726</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp; TV</th><td>3,607</td></tr></tbody></table>';
		
        $this->assertEquals($test->generate(), $result); 
        
        $test->displayRowColHierarchyTitle = false;
        
        $result = '<table class="olapGrid"><thead><tr><th rowspan="">Promotion Media</th><th colspan="1">Unit Sales</th></tr></thead><tbody><tr class="even"><th rowspan="1">&nbsp;&nbsp; Bulk Mail</th><td>4,320</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp; Cash Register Handout</th><td>6,697</td></tr><tr class="even"><th rowspan="1">&nbsp;&nbsp; Daily Paper</th><td>7,738</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp; Daily Paper, Radio</th><td>6,891</td></tr><tr class="even"><th rowspan="1">&nbsp;&nbsp; Daily Paper, Radio, TV</th><td>9,513</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp; In-Store Coupon</th><td>3,798</td></tr><tr class="even"><th rowspan="1">&nbsp;&nbsp; No Media</th><td>195,448</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp; Product Attachment</th><td>7,544</td></tr><tr class="even"><th rowspan="1">&nbsp;&nbsp; Radio</th><td>2,454</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp; Street Handout</th><td>5,753</td></tr><tr class="even"><th rowspan="1">&nbsp;&nbsp; Sunday Paper</th><td>4,339</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp; Sunday Paper, Radio</th><td>5,945</td></tr><tr class="even"><th rowspan="1">&nbsp;&nbsp; Sunday Paper, Radio, TV</th><td>2,726</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp; TV</th><td>3,607</td></tr></tbody></table>';
        
        $this->assertEquals($test->generate(), $result);         
    }
    

    public function testColUnion2Rows()
    {
		$test = $this->generateTable('resultSet2.xml');
		
		$result = '<table class="olapGrid"><thead><tr><th class="empty" rowspan="1" colspan="1"></th><th colspan="1">Measures</th></tr><tr><th rowspan="">Education Level</th><th colspan="1">Unit Sales</th></tr></thead><tbody><tr class="even"><th rowspan="1"> All Education Levels</th><td>266,773</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp; Bachelors Degree</th><td>68,839</td></tr><tr class="even"><th rowspan="1">&nbsp;&nbsp; Graduate Degree</th><td>15,570</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp; High School Degree</th><td>78,664</td></tr><tr class="even"><th rowspan="1">&nbsp;&nbsp; Partial College</th><td>24,545</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp; Partial High School</th><td>79,155</td></tr></tbody></table>';
		
        $this->assertEquals($test->generate(), $result); 
        
        $test->displayRowColHierarchyTitle = false;
        
        $result = '<table class="olapGrid"><thead><tr><th rowspan="">Education Level</th><th colspan="1">Unit Sales</th></tr></thead><tbody><tr class="even"><th rowspan="1"> All Education Levels</th><td>266,773</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp; Bachelors Degree</th><td>68,839</td></tr><tr class="even"><th rowspan="1">&nbsp;&nbsp; Graduate Degree</th><td>15,570</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp; High School Degree</th><td>78,664</td></tr><tr class="even"><th rowspan="1">&nbsp;&nbsp; Partial College</th><td>24,545</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp; Partial High School</th><td>79,155</td></tr></tbody></table>';
        
        $this->assertEquals($test->generate(), $result); 
        
    }


    public function test3Col3Rows()
    {
		$test = $this->generateTable('resultSet3.xml');
		
		$result = '<table class="olapGrid"><thead><tr><th class="empty" rowspan="5" colspan="3"></th><th colspan="3">Measures</th></tr><tr><th colspan="1">Unit Sales</th><th colspan="1">Store Cost</th><th colspan="1">Store Sales</th></tr><tr><th colspan="3">Gender</th></tr><tr><th colspan="1">All Gender</th><th colspan="1">All Gender</th><th colspan="1">All Gender</th></tr><tr><th colspan="3">Store</th></tr><tr><th rowspan="">Education Level</th><th rowspan="">Customers</th><th rowspan="">Product</th><th colspan="1">All Stores</th><th colspan="1">All Stores</th><th colspan="1">All Stores</th></tr></thead><tbody><tr class="even"><th rowspan="1"> All Education Levels</th><th rowspan="1"> All Customers</th><th rowspan="1"> All Products</th><td>266,773</td><td>225,627.23</td><td>565,238.13</td></tr></tbody></table>';
		
        $this->assertEquals($test->generate(), $result); 
        
        $test->displayRowColHierarchyTitle = false;
        
        $result = '<table class="olapGrid"><thead><tr><th class="empty" rowspan="2" colspan="3"></th><th colspan="1">Unit Sales</th><th colspan="1">Store Cost</th><th colspan="1">Store Sales</th></tr><tr><th colspan="1">All Gender</th><th colspan="1">All Gender</th><th colspan="1">All Gender</th></tr><tr><th rowspan="">Education Level</th><th rowspan="">Customers</th><th rowspan="">Product</th><th colspan="1">All Stores</th><th colspan="1">All Stores</th><th colspan="1">All Stores</th></tr></thead><tbody><tr class="even"><th rowspan="1"> All Education Levels</th><th rowspan="1"> All Customers</th><th rowspan="1"> All Products</th><td>266,773</td><td>225,627.23</td><td>565,238.13</td></tr></tbody></table>';
        
        $this->assertEquals($test->generate(), $result); 
        
    }

    public function test3Col3RowsWithUnion()
    {
		$test = $this->generateTable('resultSet4.xml');
		
		$result = '<table class="olapGrid"><thead><tr><th class="empty" rowspan="5" colspan="3"></th><th colspan="10">Measures</th></tr><tr><th colspan="1">Unit Sales</th><th colspan="6">Store Cost</th><th colspan="3">Store Sales</th></tr><tr><th colspan="10">Gender</th></tr><tr><th colspan="1">All Gender</th><th colspan="1">All Gender</th><th colspan="4">F</th><th colspan="1">M</th><th colspan="1">All Gender</th><th colspan="1">F</th><th colspan="1">M</th></tr><tr><th colspan="10">Store</th></tr><tr><th rowspan="">Education Level</th><th rowspan="">Customers</th><th rowspan="">Product</th><th colspan="1">All Stores</th><th colspan="1">All Stores</th><th colspan="1">All Stores</th><th colspan="1">Canada</th><th colspan="1">Mexico</th><th colspan="1">USA</th><th colspan="1">All Stores</th><th colspan="1">All Stores</th><th colspan="1">All Stores</th><th colspan="1">All Stores</th></tr></thead><tbody><tr class="even"><th rowspan="25"> All Education Levels</th><th rowspan="1"> All Customers</th><th rowspan="1"> All Products</th><td>266,773</td><td>225,627.23</td><td>111,777.48</td><td>-</td><td>-</td><td>111,777.48</td><td>113,849.75</td><td>565,238.13</td><td>280,226.21</td><td>285,011.92</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp; Canada</th><th rowspan="1"> All Products</th><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr><tr class="even"><th rowspan="1">&nbsp;&nbsp; Mexico</th><th rowspan="1"> All Products</th><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp; USA</th><th rowspan="1"> All Products</th><td>266,773</td><td>225,627.23</td><td>111,777.48</td><td>-</td><td>-</td><td>111,777.48</td><td>113,849.75</td><td>565,238.13</td><td>280,226.21</td><td>285,011.92</td></tr><tr class="even"><th rowspan="19">&nbsp;&nbsp;&nbsp;&nbsp; CA</th><th rowspan="1"> All Products</th><td>74,748</td><td>63,530.43</td><td>31,591.62</td><td>-</td><td>-</td><td>31,591.62</td><td>31,938.81</td><td>159,167.84</td><td>79,050.79</td><td>80,117.05</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp; Drink</th><td>7,102</td><td>5,662.27</td><td>2,831.33</td><td>-</td><td>-</td><td>2,831.33</td><td>2,830.94</td><td>14,203.24</td><td>7,108.45</td><td>7,094.79</td></tr><tr class="even"><th rowspan="1">&nbsp;&nbsp; Food</th><td>53,656</td><td>45,980.35</td><td>23,010.70</td><td>-</td><td>-</td><td>23,010.70</td><td>22,969.65</td><td>115,193.17</td><td>57,530.61</td><td>57,662.56</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp;&nbsp;&nbsp; Baked Goods</th><td>2,150</td><td>1,829.43</td><td>887.87</td><td>-</td><td>-</td><td>887.87</td><td>941.55</td><td>4,619.81</td><td>2,227.05</td><td>2,392.76</td></tr><tr class="even"><th rowspan="1">&nbsp;&nbsp;&nbsp;&nbsp; Baking Goods</th><td>5,799</td><td>4,442.51</td><td>2,077.30</td><td>-</td><td>-</td><td>2,077.30</td><td>2,365.21</td><td>11,217.84</td><td>5,213.19</td><td>6,004.65</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp;&nbsp;&nbsp; Breakfast Foods</th><td>938</td><td>793.97</td><td>482.87</td><td>-</td><td>-</td><td>482.87</td><td>311.10</td><td>2,000.55</td><td>1,212.41</td><td>788.14</td></tr><tr class="even"><th rowspan="1">&nbsp;&nbsp;&nbsp;&nbsp; Canned Foods</th><td>5,268</td><td>4,438.22</td><td>2,267.01</td><td>-</td><td>-</td><td>2,267.01</td><td>2,171.21</td><td>11,085.92</td><td>5,617.98</td><td>5,467.94</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp;&nbsp;&nbsp; Canned Products</th><td>448</td><td>336.72</td><td>140.19</td><td>-</td><td>-</td><td>140.19</td><td>196.53</td><td>861.94</td><td>357.65</td><td>504.29</td></tr><tr class="even"><th rowspan="1">&nbsp;&nbsp;&nbsp;&nbsp; Dairy</th><td>3,534</td><td>3,343.12</td><td>1,752.84</td><td>-</td><td>-</td><td>1,752.84</td><td>1,590.27</td><td>8,368.87</td><td>4,385.54</td><td>3,983.33</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp;&nbsp;&nbsp; Deli</th><td>3,393</td><td>2,842.18</td><td>1,470.75</td><td>-</td><td>-</td><td>1,470.75</td><td>1,371.43</td><td>7,132.95</td><td>3,693.87</td><td>3,439.08</td></tr><tr class="even"><th rowspan="1">&nbsp;&nbsp;&nbsp;&nbsp; Eggs</th><td>1,116</td><td>1,022.53</td><td>457.74</td><td>-</td><td>-</td><td>457.74</td><td>564.78</td><td>2,530.01</td><td>1,132.88</td><td>1,397.13</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp;&nbsp;&nbsp; Frozen Foods</th><td>7,505</td><td>6,252.82</td><td>3,178.57</td><td>-</td><td>-</td><td>3,178.57</td><td>3,074.24</td><td>15,634.34</td><td>7,888.72</td><td>7,745.62</td></tr><tr class="even"><th rowspan="1">&nbsp;&nbsp;&nbsp;&nbsp; Meat</th><td>527</td><td>452.88</td><td>215.41</td><td>-</td><td>-</td><td>215.41</td><td>237.47</td><td>1,115.46</td><td>536.29</td><td>579.17</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp;&nbsp;&nbsp; Produce</th><td>10,588</td><td>9,203.98</td><td>4,539.95</td><td>-</td><td>-</td><td>4,539.95</td><td>4,664.03</td><td>23,130.17</td><td>11,369.48</td><td>11,760.69</td></tr><tr class="even"><th rowspan="1">&nbsp;&nbsp;&nbsp;&nbsp; Seafood</th><td>441</td><td>402.64</td><td>228.77</td><td>-</td><td>-</td><td>228.77</td><td>173.87</td><td>1,017.30</td><td>583.08</td><td>434.22</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp;&nbsp;&nbsp; Snack Foods</th><td>8,543</td><td>7,656.52</td><td>3,737.93</td><td>-</td><td>-</td><td>3,737.93</td><td>3,918.59</td><td>19,072.42</td><td>9,377.27</td><td>9,695.15</td></tr><tr class="even"><th rowspan="1">&nbsp;&nbsp;&nbsp;&nbsp; Snacks</th><td>1,958</td><td>1,676.92</td><td>898.47</td><td>-</td><td>-</td><td>898.47</td><td>778.45</td><td>4,192.50</td><td>2,252.29</td><td>1,940.21</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp;&nbsp;&nbsp; Starchy Foods</th><td>1,448</td><td>1,285.92</td><td>675.03</td><td>-</td><td>-</td><td>675.03</td><td>610.89</td><td>3,213.09</td><td>1,682.91</td><td>1,530.18</td></tr><tr class="even"><th rowspan="1">&nbsp;&nbsp; Non-Consumable</th><td>13,990</td><td>11,887.80</td><td>5,749.59</td><td>-</td><td>-</td><td>5,749.59</td><td>6,138.22</td><td>29,771.43</td><td>14,411.73</td><td>15,359.70</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp;&nbsp;&nbsp; OR</th><th rowspan="1"> All Products</th><td>67,659</td><td>56,772.50</td><td>27,864.51</td><td>-</td><td>-</td><td>27,864.51</td><td>28,907.99</td><td>142,277.07</td><td>69,825.44</td><td>72,451.63</td></tr><tr class="even"><th rowspan="1">&nbsp;&nbsp;&nbsp;&nbsp; WA</th><th rowspan="1"> All Products</th><td>124,366</td><td>105,324.31</td><td>52,321.35</td><td>-</td><td>-</td><td>52,321.35</td><td>53,002.96</td><td>263,793.22</td><td>131,349.98</td><td>132,443.24</td></tr></tbody></table>';
		
        $this->assertEquals($test->generate(), $result); 
        
        $test->displayRowColHierarchyTitle = false;
        
        $result = '<table class="olapGrid"><thead><tr><th class="empty" rowspan="2" colspan="3"></th><th colspan="1">Unit Sales</th><th colspan="6">Store Cost</th><th colspan="3">Store Sales</th></tr><tr><th colspan="1">All Gender</th><th colspan="1">All Gender</th><th colspan="4">F</th><th colspan="1">M</th><th colspan="1">All Gender</th><th colspan="1">F</th><th colspan="1">M</th></tr><tr><th rowspan="">Education Level</th><th rowspan="">Customers</th><th rowspan="">Product</th><th colspan="1">All Stores</th><th colspan="1">All Stores</th><th colspan="1">All Stores</th><th colspan="1">Canada</th><th colspan="1">Mexico</th><th colspan="1">USA</th><th colspan="1">All Stores</th><th colspan="1">All Stores</th><th colspan="1">All Stores</th><th colspan="1">All Stores</th></tr></thead><tbody><tr class="even"><th rowspan="25"> All Education Levels</th><th rowspan="1"> All Customers</th><th rowspan="1"> All Products</th><td>266,773</td><td>225,627.23</td><td>111,777.48</td><td>-</td><td>-</td><td>111,777.48</td><td>113,849.75</td><td>565,238.13</td><td>280,226.21</td><td>285,011.92</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp; Canada</th><th rowspan="1"> All Products</th><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr><tr class="even"><th rowspan="1">&nbsp;&nbsp; Mexico</th><th rowspan="1"> All Products</th><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp; USA</th><th rowspan="1"> All Products</th><td>266,773</td><td>225,627.23</td><td>111,777.48</td><td>-</td><td>-</td><td>111,777.48</td><td>113,849.75</td><td>565,238.13</td><td>280,226.21</td><td>285,011.92</td></tr><tr class="even"><th rowspan="19">&nbsp;&nbsp;&nbsp;&nbsp; CA</th><th rowspan="1"> All Products</th><td>74,748</td><td>63,530.43</td><td>31,591.62</td><td>-</td><td>-</td><td>31,591.62</td><td>31,938.81</td><td>159,167.84</td><td>79,050.79</td><td>80,117.05</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp; Drink</th><td>7,102</td><td>5,662.27</td><td>2,831.33</td><td>-</td><td>-</td><td>2,831.33</td><td>2,830.94</td><td>14,203.24</td><td>7,108.45</td><td>7,094.79</td></tr><tr class="even"><th rowspan="1">&nbsp;&nbsp; Food</th><td>53,656</td><td>45,980.35</td><td>23,010.70</td><td>-</td><td>-</td><td>23,010.70</td><td>22,969.65</td><td>115,193.17</td><td>57,530.61</td><td>57,662.56</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp;&nbsp;&nbsp; Baked Goods</th><td>2,150</td><td>1,829.43</td><td>887.87</td><td>-</td><td>-</td><td>887.87</td><td>941.55</td><td>4,619.81</td><td>2,227.05</td><td>2,392.76</td></tr><tr class="even"><th rowspan="1">&nbsp;&nbsp;&nbsp;&nbsp; Baking Goods</th><td>5,799</td><td>4,442.51</td><td>2,077.30</td><td>-</td><td>-</td><td>2,077.30</td><td>2,365.21</td><td>11,217.84</td><td>5,213.19</td><td>6,004.65</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp;&nbsp;&nbsp; Breakfast Foods</th><td>938</td><td>793.97</td><td>482.87</td><td>-</td><td>-</td><td>482.87</td><td>311.10</td><td>2,000.55</td><td>1,212.41</td><td>788.14</td></tr><tr class="even"><th rowspan="1">&nbsp;&nbsp;&nbsp;&nbsp; Canned Foods</th><td>5,268</td><td>4,438.22</td><td>2,267.01</td><td>-</td><td>-</td><td>2,267.01</td><td>2,171.21</td><td>11,085.92</td><td>5,617.98</td><td>5,467.94</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp;&nbsp;&nbsp; Canned Products</th><td>448</td><td>336.72</td><td>140.19</td><td>-</td><td>-</td><td>140.19</td><td>196.53</td><td>861.94</td><td>357.65</td><td>504.29</td></tr><tr class="even"><th rowspan="1">&nbsp;&nbsp;&nbsp;&nbsp; Dairy</th><td>3,534</td><td>3,343.12</td><td>1,752.84</td><td>-</td><td>-</td><td>1,752.84</td><td>1,590.27</td><td>8,368.87</td><td>4,385.54</td><td>3,983.33</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp;&nbsp;&nbsp; Deli</th><td>3,393</td><td>2,842.18</td><td>1,470.75</td><td>-</td><td>-</td><td>1,470.75</td><td>1,371.43</td><td>7,132.95</td><td>3,693.87</td><td>3,439.08</td></tr><tr class="even"><th rowspan="1">&nbsp;&nbsp;&nbsp;&nbsp; Eggs</th><td>1,116</td><td>1,022.53</td><td>457.74</td><td>-</td><td>-</td><td>457.74</td><td>564.78</td><td>2,530.01</td><td>1,132.88</td><td>1,397.13</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp;&nbsp;&nbsp; Frozen Foods</th><td>7,505</td><td>6,252.82</td><td>3,178.57</td><td>-</td><td>-</td><td>3,178.57</td><td>3,074.24</td><td>15,634.34</td><td>7,888.72</td><td>7,745.62</td></tr><tr class="even"><th rowspan="1">&nbsp;&nbsp;&nbsp;&nbsp; Meat</th><td>527</td><td>452.88</td><td>215.41</td><td>-</td><td>-</td><td>215.41</td><td>237.47</td><td>1,115.46</td><td>536.29</td><td>579.17</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp;&nbsp;&nbsp; Produce</th><td>10,588</td><td>9,203.98</td><td>4,539.95</td><td>-</td><td>-</td><td>4,539.95</td><td>4,664.03</td><td>23,130.17</td><td>11,369.48</td><td>11,760.69</td></tr><tr class="even"><th rowspan="1">&nbsp;&nbsp;&nbsp;&nbsp; Seafood</th><td>441</td><td>402.64</td><td>228.77</td><td>-</td><td>-</td><td>228.77</td><td>173.87</td><td>1,017.30</td><td>583.08</td><td>434.22</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp;&nbsp;&nbsp; Snack Foods</th><td>8,543</td><td>7,656.52</td><td>3,737.93</td><td>-</td><td>-</td><td>3,737.93</td><td>3,918.59</td><td>19,072.42</td><td>9,377.27</td><td>9,695.15</td></tr><tr class="even"><th rowspan="1">&nbsp;&nbsp;&nbsp;&nbsp; Snacks</th><td>1,958</td><td>1,676.92</td><td>898.47</td><td>-</td><td>-</td><td>898.47</td><td>778.45</td><td>4,192.50</td><td>2,252.29</td><td>1,940.21</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp;&nbsp;&nbsp; Starchy Foods</th><td>1,448</td><td>1,285.92</td><td>675.03</td><td>-</td><td>-</td><td>675.03</td><td>610.89</td><td>3,213.09</td><td>1,682.91</td><td>1,530.18</td></tr><tr class="even"><th rowspan="1">&nbsp;&nbsp; Non-Consumable</th><td>13,990</td><td>11,887.80</td><td>5,749.59</td><td>-</td><td>-</td><td>5,749.59</td><td>6,138.22</td><td>29,771.43</td><td>14,411.73</td><td>15,359.70</td></tr><tr class="odd"><th rowspan="1">&nbsp;&nbsp;&nbsp;&nbsp; OR</th><th rowspan="1"> All Products</th><td>67,659</td><td>56,772.50</td><td>27,864.51</td><td>-</td><td>-</td><td>27,864.51</td><td>28,907.99</td><td>142,277.07</td><td>69,825.44</td><td>72,451.63</td></tr><tr class="even"><th rowspan="1">&nbsp;&nbsp;&nbsp;&nbsp; WA</th><th rowspan="1"> All Products</th><td>124,366</td><td>105,324.31</td><td>52,321.35</td><td>-</td><td>-</td><td>52,321.35</td><td>53,002.96</td><td>263,793.22</td><td>131,349.98</td><td>132,443.24</td></tr></tbody></table>';
        
        $this->assertEquals($test->generate(), $result); 
        
    }


    protected function generateTable($xmlFile)
    {
		$statementResult = new \DOMDocument();
		$statementResult->load(__DIR__.'/exemples/' . $xmlFile);
		$node = $statementResult->getElementsByTagName('root')->item(0);
		$resultSet = new ResultSet();
		$resultSet->hydrate($node);
		return new HtmlTableLayout($resultSet);
    }

}