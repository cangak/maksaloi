<h1>Daftar Pengguna</h1>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user->id ?></td>
                <td><?= $user->email ?></td>
                <td><?= $user->role_id ?></td>
                <td><?= $user->is_active ? 'Aktif' : 'Tidak Aktif' ?></td>
                <td>
                    <a href="<?= site_url('user/edit/'.$user->id) ?>">Edit</a> |
                    <a href="<?= site_url('user/delete/'.$user->id) ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
