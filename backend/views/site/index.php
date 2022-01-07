<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Drive Files</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>title</th>
                <th>thumbnailLink</th>
                <th>EmbedLink (Download) Link</th>
                <th>modifiedDate</th>
                <th>FileSize (MB)</th>
                <th>ownerNames</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($files as $file) { ?>
                <tr>
                    <!-- <pre>
                        <?= print_r($file) ?>
                    </pre> -->
                    <td><?= $file['title'] ?></td>
                    <td><img src="<?= array_key_exists('thumbnailLink', $file) ? $file['thumbnailLink'] : "No thumbnail" ?>" style="width: 70%"></td>
                    <td><a download href="<?= $file['webContentLink'] ?>">Download</a></td>
                    <td><?= $file['modifiedDate'] ?></td>
                    <td><?= number_format($file['fileSize'] / (1024 * 1024), 2, '.', ''); ?> MB</td>
                    <td><?= implode(", ", $file['ownerNames']) ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>