<?php
/**
 * Paginator.
 *
 * This file is part of MeTools.
 *
 * MeTools is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * MeTools is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with MeTools.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author	Mirko Pagliai <mirko.pagliai@gmail.com>
 * @copyright	Copyright (c) 2013, Mirko Pagliai for Nova Atlantis Ltd
 * @license	http://www.gnu.org/licenses/agpl.txt AGPL License
 * @link	http://git.novatlantis.it Nova Atlantis Ltd
 * @package	MeTools\View\Elements
 */
?>

<?php if($this->Paginator->hasPage(NULL, 2)): #If the page "2" exists, so if there is more than one page ?>
    <div class="text-center">
        <ul class="pagination">
            <?php
                echo $this->Paginator->prev();
                echo $this->Paginator->numbers();
                echo $this->Paginator->next();
            ?>
        </ul>
    </div>
<?php endif; ?>