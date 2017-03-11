package com.inventory.cis;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.Dialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Color;
import android.graphics.Interpolator;
import android.graphics.Typeface;
import android.graphics.drawable.ColorDrawable;
import android.os.AsyncTask;
import android.os.Bundle;
import android.text.InputType;
import android.util.Log;
import android.view.View;
import android.view.Window;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.Spinner;
import android.widget.TextView;
import android.view.View.OnClickListener;
import android.widget.Toast;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import static com.inventory.cis.SessionManager.KEY_UserId;

/**
 * Created by Administrator on 12/19/2016.
 */

public class ViewDetailInventoryActivity extends Activity implements OnClickListener, AdapterView.OnItemSelectedListener {

    Typeface Set_font;
    TextView txtPartNumber, txtSerialNumber, txtLocation, txtRemark, txtDescription, txtRegisterTime,txtQuantity, txtRegisterUser;
    TextView txtRemoveQuantity, txtRemoveMark;
    Button btnRemove;
    ImageView imgView;
    Spinner spinRemoveQuantity;
    SessionManager session;

    String part_number, serial_number, location, remark, description, register_time, register_user, image;

    Integer inventory_id, user_id, quantity;
    String result, Response_code;
    List<Integer> remove_quantity = new ArrayList<Integer>();


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.view_detail_inventory);
        setContent();
        SetFont();


    }

    private void setContent() {
        // TODO Auto-generated method stub
        session = new SessionManager(getApplicationContext());

        imgView = (ImageView) findViewById(R.id.image);
        txtPartNumber = (TextView) findViewById(R.id.txt_partnum);
        txtSerialNumber = (TextView) findViewById(R.id.txt_serialnum);
        txtLocation = (TextView) findViewById(R.id.txt_location);
        txtRemark = (TextView) findViewById(R.id.txt_remark);
        txtQuantity = (TextView) findViewById(R.id.txt_quantity);
        txtDescription = (TextView) findViewById(R.id.txt_description);
        txtRegisterTime = (TextView) findViewById(R.id.txt_registertime);
        txtRegisterUser = (TextView) findViewById(R.id.txt_registeruser);
        txtRemoveQuantity = (TextView)findViewById(R.id.txt_removequantity);
        txtRemoveMark = (TextView) findViewById(R.id.txt_quantity_mark);
        btnRemove = (Button) findViewById(R.id.btn_remove);
        btnRemove.setOnClickListener(this);

        spinRemoveQuantity = (Spinner) findViewById(R.id.remove_quantity);
        spinRemoveQuantity.setOnItemSelectedListener(this);



        inventory_id = getIntent().getIntExtra("inventory_id",0);
        image = getIntent().getStringExtra("image");
        part_number = getIntent().getStringExtra("part_number");
        serial_number = getIntent().getStringExtra("serial_number");
        remark = getIntent().getStringExtra("remark");
        description = getIntent().getStringExtra("description");
        location = getIntent().getStringExtra("location");
        quantity = getIntent().getIntExtra("quantity", 0);
        register_time = getIntent().getStringExtra("register_time");
        register_user = getIntent().getStringExtra("register_user");

        txtPartNumber.setText(part_number);
        txtSerialNumber.setText(serial_number);
        txtLocation.setText(location);
        if (quantity != 0)
            txtQuantity.setText(String.valueOf(quantity));
        txtRemark.setText(remark);
        txtDescription.setText(description);
        txtRegisterUser.setText(register_user);
        txtRegisterTime.setText(register_time);
        if (imgView != null) {
            ImageLoader imgLoader = new ImageLoader(getApplicationContext());

            imgLoader.DisplayImage(image,imgView);
        }

        if (quantity >1) {
            for (int i = 0; i < quantity; i++) {
                remove_quantity.add(i + 1);
            }
        }
        else
            spinRemoveQuantity.setVisibility(View.GONE);

        ArrayAdapter<Integer> dataAdapter = new ArrayAdapter<Integer>(this, android.R.layout.simple_spinner_item, remove_quantity);
        dataAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        spinRemoveQuantity.setAdapter(dataAdapter);
    }

    private void SetFont() {
        Set_font = Typeface.createFromAsset(
                getApplicationContext().getAssets(), "fonts/AGENCYR.TTF");

        btnRemove.setTypeface(Set_font);
        txtPartNumber.setTypeface(Set_font);
        txtSerialNumber.setTypeface(Set_font);
        txtLocation.setTypeface(Set_font);
        txtRemark.setTypeface(Set_font);
        txtQuantity.setTypeface(Set_font);
        txtDescription.setTypeface(Set_font);
        txtRegisterUser.setTypeface(Set_font);
        txtRegisterTime.setTypeface(Set_font);
        txtRemoveMark.setTypeface(Set_font);
        txtRemoveQuantity.setTypeface(Set_font);
    }

    @Override
    public void onClick(View view) {
        switch (view.getId()) {
            case R.id.btn_remove:
                HashMap<String, String> userDetail;
                userDetail = session.getUserDetails();
                user_id = Integer.parseInt(userDetail.get(KEY_UserId));

                AlertDialog.Builder builder = new AlertDialog.Builder(this);
                builder.setTitle("Remove inventory")
                        .setMessage("Are you sure you want to remove this inventory?")
                        .setIcon(android.R.drawable.ic_dialog_alert)
                        .setPositiveButton("Yes",
                                new DialogInterface.OnClickListener() {
                                    public void onClick(DialogInterface dialog,
                                                        int which) {
                                        // Yes button clicked, do something
                                        new RemoveOperation().execute();
                                        //finish();
                                    }
                                }).setNegativeButton("No", null) // Do nothing on no
                        .show();


                break;

        }
    }

    @Override
    public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
        // On selecting a spinner item
        quantity = remove_quantity.get(position);
        txtRemoveQuantity.setText(quantity.toString());

        // Showing selected spinner item
        //Toast.makeText(parent.getContext(), "Selected: " + item, Toast.LENGTH_LONG).show();
    }

    @Override
    public void onNothingSelected(AdapterView<?> adapterView) {

    }

    private class RemoveOperation extends AsyncTask<String, Void, Void> {

        Dialog pDialog = new Dialog(ViewDetailInventoryActivity.this);

        protected void onPreExecute() {
            // Dialog.setMessage("Authanticating...");
            pDialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
            pDialog.getWindow().setBackgroundDrawable(
                    new ColorDrawable(Color.TRANSPARENT));
            pDialog.setContentView(R.layout.custom_image_dialog);
            pDialog.show();
            pDialog.setCancelable(false);
        }

        // Call after onPreExecute method
        protected Void doInBackground(String... urls) {

            try {

                postData();


                Log.d("....", "...." + Response_code);

                JSONObject jobj = new JSONObject(Response_code);
                Boolean error = jobj.getBoolean("error");
                Log.d("Result", "...." + error);

                if (!error)
                    SuccessRemove();
                else
                    Toast.makeText(ViewDetailInventoryActivity.this, "Failed remove operation.", Toast.LENGTH_SHORT).show();


            } catch (JSONException e) {
                // TODO Auto-generated catch block
                //e.printStackTrace();
            } catch (NullPointerException n) {
                n.printStackTrace();
            }

            return null;
        }


        protected void onPostExecute(Void unused) {

            try {
                if (pDialog.isShowing())
                    pDialog.dismiss();

            } catch (Exception e) {
                // TODO: handle exception
                //e.printStackTrace();
            }

        }
    }

    private void SuccessRemove() {
        Intent i = new Intent(this, ViewInventoryActicity.class);
        startActivity(i);
    }

    public void postData() throws NullPointerException {
        // TODO Auto-generated method stub

        try {

            JSONObject json = new JSONObject();

            json.put("inventory_id", inventory_id);
            json.put("user_id", user_id);
            json.put("quantity", quantity);

            String url = StaticData.getlink(getApplicationContext()) + "remove_inventory.php";
            Log.d("url------", url);

            ServiceHandler sh = new ServiceHandler();
            // Making a request to url and getting response
            String jsonStr = sh.makeRequest(url, ServiceHandler.POST, json.toString());
            result = jsonStr;
        } catch (Throwable t) {
            Toast.makeText(this, "Request failed: " + t.toString(),Toast.LENGTH_LONG).show();
        }
        try {
            Response_code = result;
        } catch (Exception e) {
            //e.printStackTrace();
        }
    }




}
