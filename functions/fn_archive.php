<?php
/*
Archive:
    an array with id of the attribute to be archived
*/

function _archive(int $id, string $attr): bool
{
    // no validator here
    $archives = _readArchives();
    // checking if the id is already archived
    if (in_array($id, $archives[$attr])) {
        return false;
    }
    array_push($archives[$attr], $id);
    if (_saveArchives($archives)) {
        return $id;
    } else {
        // error saving the archive json file
        return false;
    }
}

function _getArchives(string $attr): array
{
    // returns archives of the attribute
    return _readArchives()[$attr];
}
function _readArchives(): array
{
    return _getDataFromFileName(ARCHIVE);
}

function _saveArchives(array $all_archives): bool
{
    return _writeDataToFile(ARCHIVE, $all_archives);
}
