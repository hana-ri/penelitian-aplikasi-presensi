<div class="dropdown">
    <a class="btn btn-sm btn-primary dropdown-toggle" href="#" role="button" id="categoryDropdownButton"
        data-bs-toggle="dropdown" aria-expanded="false"> Opsi </a>
    <ul class="dropdown-menu" aria-labelledby="categoryDropdownButton">
        <li>
            <a class="dropdown-item edit-tag-button" href="{{ route('admin.attendance.update', ['meeting_id' => $meeting->id, 'user_id' => $user->id, 'action' => 'Hadir']) }}">Hadir</a>
        </li>
        <li>
            <a class="dropdown-item edit-tag-button" href="{{ route('admin.attendance.update', ['meeting_id' => $meeting->id, 'user_id' => $user->id, 'action' => 'Absen']) }}">Absen</a>
        </li>
        <li>
            <a class="dropdown-item edit-tag-button" href="{{ route('admin.attendance.update', ['meeting_id' => $meeting->id, 'user_id' => $user->id, 'action' => 'Sakit']) }}">Sakit</a>
        </li>
        <li>
            <a class="dropdown-item edit-tag-button" href="{{ route('admin.attendance.update', ['meeting_id' => $meeting->id, 'user_id' => $user->id, 'action' => 'Izin']) }}">Izin</a>
        </li>
    </ul>
</div>
