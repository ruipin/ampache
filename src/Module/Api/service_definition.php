<?php
/*
 * vim:set softtabstop=4 shiftwidth=4 expandtab:
 *
 * LICENSE: GNU Affero General Public License, version 3 (AGPL-3.0-or-later)
 * Copyright 2001 - 2022 Ampache.org
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
 *
 */

declare(strict_types=1);

namespace Ampache\Module\Api;

use Ampache\Module\Api\Output\ApiOutputFactory;
use Ampache\Module\Api\Output\ApiOutputFactoryInterface;
use function DI\autowire;

return [
    XmlApiApplication::class => autowire(),
    JsonApiApplication::class => autowire(),
    SubsonicApiApplication::class => autowire(),
    DaapApiApplication::class => autowire(),
    SseApiApplication::class => autowire(),
    ApiOutputFactoryInterface::class => autowire(ApiOutputFactory::class),
    ApiHandlerInterface::class => autowire(ApiHandler::class),
    Method\AlbumsMethod::class => autowire(),
    Method\AlbumMethod::class => autowire(),
    Edit\EditObjectAction::class => autowire(),
    Edit\RefreshUpdatedAction::class => autowire(),
    Edit\ShowEditObjectAction::class => autowire(),
    Edit\ShowEditPlaylistAction::class => autowire(),
];