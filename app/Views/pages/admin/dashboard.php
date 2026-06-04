<?php
/**
 * Admin Dashboard View
 * Included within the main layout.
 * Available vars: $applications, $events, $notices
 */
?>

<section class="section admin-section">
    <div class="container">
        <h2 class="section-title">Admin <span class="accent">Dashboard</span></h2>

        <?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
        <?php if (!empty($_SESSION['flash_success']['admin'])): ?>
            <div class="alert alert-success" style="background-color: #00cc66; color: white; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
                <strong>Success:</strong> <?= htmlspecialchars($_SESSION['flash_success']['admin']) ?>
            </div>
            <?php unset($_SESSION['flash_success']['admin']); ?>
        <?php endif; ?>

        <?php if (!empty($_SESSION['flash_errors']['admin'])): ?>
            <div class="alert alert-error" style="background-color: #ff4444; color: white; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
                <strong>Error:</strong> <?= htmlspecialchars($_SESSION['flash_errors']['admin']) ?>
            </div>
            <?php unset($_SESSION['flash_errors']['admin']); ?>
        <?php endif; ?>

        <div style="display: flex; gap: 15px; margin-bottom: 30px; border-bottom: 1px solid #333; padding-bottom: 15px; overflow-x: auto;">
            <a href="?tab=applications" style="padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; color: <?= $activeTab === 'applications' ? '#000' : '#00ffcc' ?>; background-color: <?= $activeTab === 'applications' ? '#00ffcc' : 'transparent' ?>; border: 1px solid #00ffcc;">Applications</a>
            <a href="?tab=members" style="padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; color: <?= $activeTab === 'members' ? '#000' : '#00ffcc' ?>; background-color: <?= $activeTab === 'members' ? '#00ffcc' : 'transparent' ?>; border: 1px solid #00ffcc;">Members</a>
            <a href="?tab=events" style="padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; color: <?= $activeTab === 'events' ? '#000' : '#00ffcc' ?>; background-color: <?= $activeTab === 'events' ? '#00ffcc' : 'transparent' ?>; border: 1px solid #00ffcc;">Events</a>
            <a href="?tab=notices" style="padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; color: <?= $activeTab === 'notices' ? '#000' : '#00ffcc' ?>; background-color: <?= $activeTab === 'notices' ? '#00ffcc' : 'transparent' ?>; border: 1px solid #00ffcc;">Notices</a>
        </div>

                <?php if ($activeTab === 'applications'): ?>
        <div class="admin-panel">
            <h3>Club Join Applications</h3>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Student ID</th>
                            <th>Dept</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($applications)): ?>
                            <tr><td colspan="6">No applications found.</td></tr>
                        <?php else: ?>
                            <?php foreach ($applications as $m): ?>
                            <tr>
                                <td>
                                    <?php if ($m['image_url']): ?>
                                        <img src="<?= htmlspecialchars($m['image_url']) ?>" alt="Photo" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                                    <?php else: ?>
                                        <div style="width: 50px; height: 50px; border-radius: 50%; background-color: #333;"></div>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($m['full_name']) ?></td>
                                <td><?= htmlspecialchars($m['email']) ?></td>
                                <td><?= htmlspecialchars($m['student_id']) ?></td>
                                <td><?= htmlspecialchars($m['department']) ?></td>
                                <td><?= htmlspecialchars(date('M d, Y', strtotime($m['created_at']))) ?></td>
                                <td>
                                    <div style="display: flex; gap: 10px; align-items: center;">
                                        <form action="<?= url('admin.php') ?>" method="POST" style="margin: 0;">
                                            <input type="hidden" name="tab" value="applications">
                                            <input type="hidden" name="action" value="approve_application">
                                            <input type="hidden" name="id" value="<?= $m['id'] ?>">
                                            <select name="role" required style="padding: 5px; background: #222; color: #fff; border: 1px solid #444; width: 150px;">
                                                <option value="" disabled selected>Select Role</option>
                                                <option value="President / Convener">President / Convener</option>
                                                <option value="Vice President / Joint Convener">Vice President / Joint Convener</option>
                                                <option value="General Secretary">General Secretary</option>
                                                <option value="Assistant General Secretary">Assistant General Secretary</option>
                                                <option value="Treasurer">Treasurer</option>
                                                <option value="Chief Student Editor">Chief Student Editor</option>
                                                <option value="Associate / Assistant Editors">Associate / Assistant Editors</option>
                                                <option value="Research & Workshop Coordinator">Research & Workshop Coordinator</option>
                                                <option value="Publication & Press Secretary">Publication & Press Secretary</option>
                                                <option value="Graphics & UI Design Lead">Graphics & UI Design Lead</option>
                                                <option value="Graphics Executives">Graphics Executives</option>
                                                <option value="Public Relations & Communications Secretary">Public Relations & Communications Secretary</option>
                                                <option value="PR Associates">PR Associates</option>
                                                <option value="Media & Content Lead">Media & Content Lead</option>
                                                <option value="Content Writers">Content Writers</option>
                                                <option value="Logistics Secretary">Logistics Secretary</option>
                                                <option value="Logistics Crew">Logistics Crew</option>
                                            </select>
                                            <button type="submit" style="background-color: #00ffcc; color: black; border: none; padding: 5px 10px; cursor: pointer; font-weight: bold; border-radius: 3px;">Approve</button>
                                        </form>
                                        <form action="<?= url('admin.php') ?>" method="POST" style="margin: 0;" onsubmit="return confirm('Delete this application?');">
                                            <input type="hidden" name="tab" value="applications">
                                            <input type="hidden" name="action" value="delete_application">
                                            <input type="hidden" name="id" value="<?= $m['id'] ?>">
                                            <button type="submit" style="background-color: #ff4444; color: white; border: none; padding: 5px 10px; cursor: pointer; font-weight: bold; border-radius: 3px;">Reject</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>

                <?php if ($activeTab === 'members'): ?>
        <div class="admin-panel">
            <h3>Club Members</h3>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th>Dept</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($members)): ?>
                            <tr><td colspan="8">No members found.</td></tr>
                        <?php else: ?>
                            <?php foreach ($members as $m): ?>
                            <tr>
                                <td>
                                    <?php if ($m['image_url']): ?>
                                        <img src="<?= htmlspecialchars($m['image_url']) ?>" alt="Photo" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                                    <?php else: ?>
                                        <div style="width: 50px; height: 50px; border-radius: 50%; background-color: #333;"></div>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($m['full_name']) ?></td>
                                <td><strong><?= htmlspecialchars($m['role']) ?></strong></td>
                                <td><?= htmlspecialchars($m['email']) ?></td>
                                <td><?= htmlspecialchars($m['department']) ?></td>
                                <td><?= htmlspecialchars(date('M d, Y', strtotime($m['joined_at']))) ?></td>
                                <td>
                                    <form action="<?= url('admin.php') ?>" method="POST" onsubmit="return confirm('Remove this member?');">
                                        <input type="hidden" name="tab" value="members">
                                        <input type="hidden" name="action" value="delete_member">
                                        <input type="hidden" name="id" value="<?= $m['id'] ?>">
                                        <button type="submit" style="background-color: #ff4444; color: white; border: none; padding: 5px 10px; cursor: pointer; font-weight: bold; border-radius: 3px;">Remove</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>

                <?php if ($activeTab === 'events'): ?>
        <div class="admin-panel">
            <h3>Manage Events</h3>
            
            <form action="<?= url('admin.php') ?>" method="POST" class="admin-form">
                <input type="hidden" name="tab" value="events">
                <input type="hidden" name="action" value="add_event">
                <div class="form-row">
                    <input type="text" name="title" placeholder="Event Title" required class="form-control" style="padding: 15px; font-size: 16px;">
                    <input type="date" name="event_date" required class="form-control" style="padding: 15px; font-size: 16px;">
                </div>
                <textarea name="description" placeholder="Event Description" required class="form-control" style="width: 100%; box-sizing: border-box; padding: 15px; font-size: 16px; min-height: 150px; margin-bottom: 15px;"></textarea>
                <button type="submit" class="btn-primary">Add Event</button>
            </form>

            <div class="table-responsive" style="margin-top: 20px;">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($events)): ?>
                            <tr><td colspan="4">No events found.</td></tr>
                        <?php else: ?>
                            <?php foreach ($events as $e): ?>
                            <tr>
                                <td>
                                    <strong><?= htmlspecialchars($e['title']) ?></strong><br>
                                    <small style="color:#aaa;"><?= htmlspecialchars($e['description']) ?></small>
                                </td>
                                <td><?= htmlspecialchars(date('M d, Y', strtotime($e['event_date']))) ?></td>
                                <td>
                                    <span class="status-badge status-<?= strtolower($e['status']) ?>"><?= $e['status'] ?></span>
                                </td>
                                <td>
                                    <form action="<?= url('admin.php') ?>" method="POST" onsubmit="return confirm('Delete this event?');">
                                        <input type="hidden" name="tab" value="events">
                                        <input type="hidden" name="action" value="delete_event">
                                        <input type="hidden" name="id" value="<?= $e['id'] ?>">
                                        <button type="submit" class="btn-delete">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>

                <?php if ($activeTab === 'notices'): ?>
        <div class="admin-panel">
            <h3>Manage Notices</h3>
            
            <form action="<?= url('admin.php') ?>" method="POST" class="admin-form">
                <input type="hidden" name="tab" value="notices">
                <input type="hidden" name="action" value="add_notice">
                <input type="text" name="title" placeholder="Notice Title" required class="form-control" style="padding: 15px; font-size: 16px; margin-bottom: 15px; width: 100%;">
                <textarea name="content" placeholder="Notice Content" required class="form-control" style="padding: 15px; font-size: 16px; margin-bottom: 15px; width: 100%; min-height: 150px;"></textarea>
                <button type="submit" class="btn-primary">Add Notice</button>
            </form>

            <div class="table-responsive" style="margin-top: 20px;">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Title / Content</th>
                            <th>Posted On</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($notices)): ?>
                            <tr><td colspan="3">No notices found.</td></tr>
                        <?php else: ?>
                            <?php foreach ($notices as $n): ?>
                            <tr>
                                <td>
                                    <strong><?= htmlspecialchars($n['title']) ?></strong><br>
                                    <small style="color:#aaa;"><?= htmlspecialchars($n['content']) ?></small>
                                </td>
                                <td><?= htmlspecialchars(date('M d, Y', strtotime($n['created_at']))) ?></td>
                                <td>
                                    <form action="<?= url('admin.php') ?>" method="POST" onsubmit="return confirm('Delete this notice?');">
                                        <input type="hidden" name="tab" value="notices">
                                        <input type="hidden" name="action" value="delete_notice">
                                        <input type="hidden" name="id" value="<?= $n['id'] ?>">
                                        <button type="submit" class="btn-delete">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>

    </div>
</section>
