    <div class="modal fade" id="editModal${formattedData.account_id}" tabindex="-1" aria-labelledby="loginModalLabel"
        aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Edit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id='editEmployee'>
                    <div class="modal-body">
                        <div>
                            <label>Username</label>
                            <input type="text" class="form-control" value="${formattedData.username}" name="username">
                            <label>Password</label>
                            <input type="text" class="form-control" value="${formattedData.password}" name="password">
                        </div>
                        <div>
                            <label>Role</label>
                            <select name="login_role" class="form-select">
                                <option value="Admin">Admin</option>
                                <option value="Employee">Employee</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" value="${formattedData.account_id}" name="account_id">
                        <button type="submit" class="btn btn-success">Confirm</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>