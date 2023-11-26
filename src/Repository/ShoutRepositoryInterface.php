<?php

/**
 * vim:set softtabstop=4 shiftwidth=4 expandtab:
 *
 * LICENSE: GNU Affero General Public License, version 3 (AGPL-3.0-or-later)
 * Copyright Ampache.org, 2001-2023
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace Ampache\Repository;

use Ampache\Repository\Model\library_item;
use Ampache\Repository\Model\Shoutbox;
use Ampache\Repository\Model\User;
use DateTimeInterface;
use Generator;
use Traversable;

interface ShoutRepositoryInterface
{
    /**
     * Returns all shout-box items for the provided object-type and -id
     *
     * @return Traversable<Shoutbox>
     */
    public function getBy(
        string $objectType,
        int $objectId
    ): Traversable;

    /**
     * Cleans out orphaned shout-box items
     */
    public function collectGarbage(?string $objectType = null, ?int $objectId = null): void;

    /**
     * this function deletes the shout-box entry
     */
    public function delete(int $shoutBoxId): void;

    /**
     * Updates the ShoutBox item with the provided data
     *
     * @param array{comment: string, sticky: bool} $data
     */
    public function update(Shoutbox $shout, array $data): void;

    /**
     * Creates a new shout entry and returns the id of the created shout item
     */
    public function create(
        User $user,
        DateTimeInterface $date,
        string $text,
        bool $isSticky,
        library_item $libItem,
        string $objectType,
        int $offset
    ): int;

    /**
     * This returns the top user_shouts, shoutbox objects are always shown regardless and count against the total
     * number of objects shown
     *
     * @return Traversable<Shoutbox>
     */
    public function getTop(int $limit, ?string $username = null): Traversable;
}
