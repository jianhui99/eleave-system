<!-- Bootstrap Pop Up Modal for leave process -->
<div class="modal fade" id="processmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Student Leave Application</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST">
                <div class="modal-body">
                <input type="hidden" name="process_id" id="process_id">
                <input type="hidden" name="student_name" id="student_name">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="select" id="select" class="form-control">
                            <option value="">Select</option>
                            <?php
                                $arr = array("Approved", "Rejected");
                                foreach($arr as $val){
                                    echo "<option value='$val'>$val</option>";
                                }
                            ?>                                      
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Remark</label>
                        <textarea class="form-control textarea" rows="4" cols="65" name="remark" id="remark" placeholder="Enter description here" ></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="process" id="process" class="btn btn-info">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JS, Popper.js, and jQuery -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>    -->